pipeline {
    agent any

    environment {
        PATH = "$PATH:/user/local/bin"
    }

    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/MSPR-2-Bloc-4/API-Clients.git', branch: 'master'
            }
        }

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
                sh 'docker-compose up'
                sh 'docker-compose exec web php bin/console debug:router'
            }
        }
    }
}