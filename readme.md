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

2- import the database "crawler.sql" which is located in the project's root directory.

3- open terminal and change directory to the project's directory.

4- run command "composer install"

5- open your browser and enter "http://localhost/php_crawler/crawler_example.php"