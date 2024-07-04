pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/MSPR-2-Bloc-4/API-Clients.git', branch: 'master'
            }
        }

        stage('Composer install') {
            steps {
                sh 'composer'
            }
        }


        stage('Run tests') {
            steps {
                sh 'php bin/phpunit tests/Entity'
            }
        }
    }
}