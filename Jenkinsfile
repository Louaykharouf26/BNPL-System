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
                       sh "az group create --name myResourceGroup1 --location eastus "     
                       sh "az aks create -g myResourceGroup1 -n myAKSCluster1 --enable-managed-identity --node-count 1 --enable-addons monitoring --generate-ssh-keys"
                     
                        sh "az aks get-credentials --resource-group myResourceGroup1 --name myAKSCluster1"
                       sh "kubectl config use-context myAKSCluster1"

                                dir('K8S') {
                            sh "kubectl apply -f dbsecret.yml"
                            sh "kubectl apply -f db-deployment.yml"
                             sh "kubectl apply -f bnpl.yml"
                            }
                        echo "installing argocd"
                        sh "kubectl create namespace argocd"
                        sh "kubectl apply -n argocd -f https://raw.githubusercontent.com/argoproj/argo-cd/stable/manifests/install.yaml"
                       sh "kubectl patch svc argocd-server -n argocd -p '{\"spec\": {\"type\": \"LoadBalancer\"}}'"

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
