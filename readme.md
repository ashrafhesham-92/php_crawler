Points to keep in mind:

- some parts of this project are customized to match exactly what was required in the task.

- the concept of how the data is structured to be retrieved and saved in the database is explained in details in the following class "application/classes/LinksTreeBuilder.php".

- structuring and saving data is really taking too much time if you tried to build more than levels 0 and 1 of the links tree (explained as mentioned in the previous point)

- you can check how to use the application in the "crawler_example.php" in the application's root directory.

- you can check the result of application after saving data of levels 0 , 1 and 2 in the database by importing "crawler_with_data.sql" database which is located in the applications root directory.

- you can also check the result of the 3 levels as JSON by parsing "example_results.json" content in any json viewer, the file is located in the application's root directory.

- you can get empty version of the database by importing "crawler.sql" which is located in the root directory of the application.


########################################################################

Steps to test the application:

1- clone or download the project.

2- create new mysql database with any name you choose.

3- import the file "crawler.sql" in your created database, the file is located in the project's root directory.

4- open the project directory and open config.php 

5- change the values of the 'db' array to match your database config.

6- open terminal and change directory to the project's directory.

7- run command "composer install".

8- *important* run command "composer dump-autoload -o".

9- open your browser and enter "http://localhost/{project name}/crawler_example.php".