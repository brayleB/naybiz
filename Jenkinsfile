pipeline {
     agent any
 
     stages { 

        stage("Build - Production") {
            steps {
                sh "composer install" 
                sh "sudo php artisan key:generate"
                sh "npm install" 
                sh "npm run build" 
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
                sh "sudo find /var/www/html/naybiz -type f -exec chmod 644 {} \\;"
                sh "sudo find /var/www/html/naybiz -type d -exec chmod 755 {} \\;"
                sh "sudo chmod -R 775 /var/www/html/naybiz/storage"
                sh "sudo chmod -R 775 /var/www/html/naybiz/bootstrap/cache"
            }
        } 

        stage("Laravel Run Migration - Production") {
            steps {
                sh "sudo php artisan migrate" 
            }
        } 

        stage('Sanity check') {
            steps {
                input "Do you want to reset the migration?"
            }
        }

        stage("Laravel Run Migration - Reset / Refresh Database ") {
            steps {
                sh "sudo php artisan migrate:refresh" 
            }
        } 
 
    }
}