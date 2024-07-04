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

        stage('Docker install') {
            steps {
                sh 'sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose'
                sh 'sudo chmod +x /usr/local/bin/docker-compose'
                sh 'sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose'
                
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