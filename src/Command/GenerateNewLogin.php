<?php
namespace App\Command;

use App\Entity\AdminPassword;
use App\Entity\AdminUser;
use App\Entity\Institution;
use App\Tools\DBTool;
use App\Tools\InstitutionActionsTool;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class GenerateNewLogin
 * @package App\Command
 */
class GenerateNewLogin extends Command{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->container = $container;
    }

    /**
     * command REQUIRES username and password to work correct
     * also config is setting a name of comand , descroption and help if someone doesn't know what this command do
     */
    protected function configure(): void
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.')
            ->setName('app:create-user-auth')
            ->setDescription('Creates a new user')
            ->setHelp('This command sets your login and password');
    }

    /**
     * command that allows the admin to login by creating his login and password or changing one existing
     *
     * @param InputInterface $input
     *
     * @param OutputInterface $output
     *
     * @return int
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loginArg = $input->getArgument('username');
        $passArg = $input->getArgument('password');

        $em = $this->container->get('doctrine');

        $dbTool = new DBTool($em);

        //--------------------------------------------------------------------------------------------------------------
        // If there is one we are trying to find him and everything is valid password is change to new one
        //--------------------------------------------------------------------------------------------------------------
        $trans = $em->getManager()->getConnection();
        $trans->beginTransaction();
        try{
            $updated_user = $dbTool->findBy(AdminUser::class, ["login" => $loginArg]);
            $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);
            if(count($updated_user) > 0){
                $updated_user = $updated_user[0];

                $passwd = $dbTool->findBy(AdminPassword::class, ["admin_id" => $updated_user]);
                if(count($passwd) > 0){
                    $passwd = $passwd[0];
                    $passwd->setPassword(md5($passArg));
                    $output->writeln("<info>Success</info>");
                    $output->writeln("Your account was updated !!!");
                }
                else{
                    $passwd = new AdminPassword($updated_user, md5($passArg));
                    $output->writeln("<info>Success</info>");
                    $output->writeln("Your account was updated !!!");
                }

                $dbTool->insertData($passwd);
            }
            else{
                try{

                    $inTool = new InstitutionActionsTool();

                    if($inTool->maxAccounts($em,true)) {
                        $user = new AdminUser($loginArg, $institution[0]);
                        $dbTool->insertData($user);

                        $password = new AdminPassword($user, md5($passArg));

                        $dbTool->insertData($password);

                        $trans->commit();

                        $output->writeln("<info>Success</info>");
                        $output->writeln("Your account was created !!!");

                        return Command::SUCCESS;
                    }
                    else{
                        $trans->rollBack();
                        $output->writeln("<error>Max Admins pull reached</error>");

                        return Command::FAILURE;
                    }
                    //--------------------------------------------------------------------------------------------------------------
                }catch (\Exception $e){
                    $trans->rollBack();
                    $output->writeln("<error>Failure</error>");
                    $output->writeln($e->getMessage());

                    return Command::FAILURE;
                }
            }
            $trans->commit();

            return Command::SUCCESS;
            //--------------------------------------------------------------------------------------------------------------
        }catch (\Exception $e){
            $trans->rollback();
            $output->writeln("<error>Failure</error>");
            $output->writeln($e->getMessage());

            return Command::FAILURE;
        }
    }
}