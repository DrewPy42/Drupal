Where files are located on D8
The D7 files are in a sub-directory of the Files folder called Import. I broke things down into subdirectories so I can manage them. The downside is that you have to setup a custom TPL for each export to make sure it points to the correct place

Views Exports folder
I exported these from Dev in case you wanted to sync from Prod. Just log into the Drupal admin account and import them.

drpal.txt contains the user name and passwords for the Postgres drupal account as well as the Drupal admin. If you have questions, ask. It also has some snippets in there that probably aren't necessary, I just didn't want to lose them.

Custom migration functions
I've added a couple functions that will make your life easier when setting up migration files.
drush mrm #this removes and rebuilds the custom config Files


On migration Files
They are pretty straight foward provided you aren't doing anything crazy. Just remember to have the correct indent or it will yell at you, but not tell you were the error is usually.


jcl_user_animals errors
These files could not be located. You might check Prod and see if they're hiding out there somewhere. Files are a jumbled mess on Prod, so good luck.

source_ids_hash                                                   level   message
142bd7db1e4a89e5a74446c678b112a2e09650365b201ff206869c52eef80d90  1       File 'public://import/images/Zora.JPG' does not exist
2a10f0767a337c1589bcdd814a5daf99831845782c87fb65f7019a6f9e3ea04b  1       File 'public://import/images/chupacabra-large.jpg' does not exist
8e079c35cf97140172cb6e35708491dc0a21de9e0b3734c5b1a9431187fdde63  1       File 'public://import/images/My Favorite Dog.JPG' does not exist
0a606656b855d3d923fdd589c3dbf2d4eb5b28b1109057d5488584d9a3d8cc55  1       File 'public://import/images/A_0.jpg' does not exist
b5cac242e7eee9f595334f606f380398e615f3fb9d281b63bb13c6f7fce3abcd  1       File 'public://import/images/fluffy_guineapig.jpg' does not exist
0a2ad9a0fc484e25063ff99d8b81c79de450a00b347e344df0a2e33e8e0698cb  1       File 'public://import/images/27344946982_2235564d50_m.jpg' does not exist


jcl_user_custom_fields errors
You'll have to access the database to get info on which files were missing and make sure that the CSV output has them.
Missing file with ID 3858. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 3764. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 197. ImageItem.php:327                                                                                                                                                                                       [warning]
Missing file with ID 3751. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 1290. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4479. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 1462. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 1461. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 3915. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4122. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 12133. ImageItem.php:327                                                                                                                                                                                     [warning]
Missing file with ID 3773. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 3932. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4207. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 8054. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4141. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4149. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4316. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4105. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4193. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4715. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4284. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 3839. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4048. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4044. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 7297. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4173. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 11283. ImageItem.php:327                                                                                                                                                                                     [warning]
Missing file with ID 4237. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4260. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 6839. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4270. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4075. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4073. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4120. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4213. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4223. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4474. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 4025. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 10425. ImageItem.php:327                                                                                                                                                                                     [warning]
Missing file with ID 4730. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 10020. ImageItem.php:327                                                                                                                                                                                     [warning]
Missing file with ID 9891. ImageItem.php:327                                                                                                                                                                                      [warning]
Missing file with ID 10524. ImageItem.php:327
