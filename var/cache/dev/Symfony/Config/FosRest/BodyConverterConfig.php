<?php

namespace Symfony\Config\FosRest;


use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;


/**
 * This class is automatically generated to help creating config.
 *
 * @experimental in 5.3
 */
class BodyConverterConfig 
{
    private $enabled;
    private $validate;
    private $validationErrorsArgument;
    
    /**
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function enabled($value): self
    {
        $this->enabled = $value;
    
        return $this;
    }
    
    /**
     * @default false
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function validate($value): self
    {
        $this->validate = $value;
    
        return $this;
    }
    
    /**
     * @default 'validationErrors'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function validationErrorsArgument($value): self
    {
        $this->validationErrorsArgument = $value;
    
        return $this;
    }
    
    public function __construct(array $value = [])
    {
    
        if (isset($value['enabled'])) {
            $this->enabled = $value['enabled'];
            unset($value['enabled']);
        }
    
        if (isset($value['validate'])) {
            $this->validate = $value['validate'];
            unset($value['validate']);
        }
    
        if (isset($value['validation_errors_argument'])) {
            $this->validationErrorsArgument = $value['validation_errors_argument'];
            unset($value['validation_errors_argument']);
        }
    
        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }
    
    
    public function toArray(): array
    {
        $output = [];
        if (null !== $this->enabled) {
            $output['enabled'] = $this->enabled;
        }
        if (null !== $this->validate) {
            $output['validate'] = $this->validate;
        }
        if (null !== $this->validationErrorsArgument) {
            $output['validation_errors_argument'] = $this->validationErrorsArgument;
        }
    
        return $output;
    }
    

}
