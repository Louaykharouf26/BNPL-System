pipeline{
    agent any
    stages{
        stage("getting code") {
            steps {
                git url: 'https://github.com/Louaykharouf26/BNPL-System.git', branch: 'master',
                credentialsId: 'github-credentials' //jenkins-github-creds
                sh "ls -ltr"
            }
        }

       stage("Setting up infra") {
            steps {                
                script {
                    echo "======== executing ========"
                        sh "pwd"
                        sh "ls"
                        echo "terraform init"
                        sh "az login"
                        sh "az group create --name myResourceGroup --location eastus "     
                       }            
                        }
                    } 
         
                }
            post{
                success{
                    echo "======== Setting up infra executed successfully ========"
                }
                failure{
                    echo "======== Setting up infra execution failed ========"
                }
            }
             
        }          
   /* 
    post{
        success{
            echo "========pipeline executed successfully ========"
        }
        failure{
            echo "========pipeline execution failed========"
        }
    }*/