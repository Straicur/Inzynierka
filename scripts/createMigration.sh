#!/bin/bash

pwd

./bin/console doctrine:migrations:migrate
./bin/console doctrine:migrations:diff
./bin/console doctrine:migrations:migrate
