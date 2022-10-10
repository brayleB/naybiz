pipeline {
     agent any
 
     stages { 

        stage("Build - Production") {
            steps {
                sh "composer install" 
            }
        }

        stage("Deploy - Production") {
            steps {
                sh "sudo rm -rf /var/www/html/naybiz"
                sh "sudo cp -r ${WORKSPACE}/ /var/www/html/naybiz/"
            }
        }

        stage("Set Permissions - Production") {
            steps {
                sh "sudo chown -R www-data:www-data /var/www/html/naybiz"
                sh "sudo find /var/www/html/naybiz -type f -exec chmod 644 {} \;"
                sh "sudo find /var/www/html/naybiz -type d -exec chmod 755 {} \;"
                sh "sudo chmod -R o+w /var/www/html/naybiz/storage"
            }
        } 
 
    }
}