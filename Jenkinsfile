pipeline {
    agent any

    stages {

        stage('Composer install') {
            steps {
                sh 'composer install'
            }
        }


        stage('Run tests') {
            steps {
                sh 'php bin/phpunit tests/Entity'
            }
        }

        stage('Docker build') {
            steps {
                sh 'ls'
                sh 'docker --version'
                sh 'docker-compose up'
                sh 'docker-compose exec web php bin/console debug:router'
            }
        }
    }
}