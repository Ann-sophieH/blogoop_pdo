<?php
include("includes/header.php");

$host = 'localhost';
$db = 'dbblogoop';
$user = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
    $pdo = new PDO($dsn, $user, $password); //connectie maken
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //errorhandling (mode = exeption)
    if ($pdo) {
        echo "Connected to the $db database successfully!"; // bevestiging connectie
    }
} catch (PDOException $e) { //errorhandling, catch error
    echo $e->getMessage(); //display message upon error
}
$sql = 'SELECT * FROM users'; //query zonder variabele params dus geen prepared statement nodig
$statement = $pdo->query($sql); //query kan hier gebruikt worden want er komen geen variabelen voor ind de query

// get all users

$users = $statement->fetchAll(PDO::FETCH_ASSOC); //retouty assoc array
/*if ($users) {
    // show the users
    foreach ($users as $user) {
        echo $user['first_name'] . '<br>';
    }
}*/
include("includes/sidebar.php");
include("includes/content-top.php");


?>
<div class="col-12 px-0">
    <div class="card">
        <div class="card-body">

            <div class="d-flex no-block align-items-center mb-4">
                <h4 class="card-title">All Contacts</h4>



                <div class="ml-auto">
                    <div class="btn-group">
                        <a href="add_user.php" class="
                            btn btn-primary
                            text-white
                            font-weight-medium
                            rounded-pill
                            px-4"><i class="fas fa-user-plus"></i>
                            Create New Contact
                        </a>
                    </div>
                </div>
            </div>
            <div>


                <div class="table" >
                    <div id="file_export_wrapper" class="container-fluid">
                        <div>
                            <button class="btn btn-primary mr-1" tabindex="0"
                                    aria-controls="file_export"><span>Copy</span></button>
                            <button class="btn btn-primary mr-1" tabindex="0"
                                    aria-controls="file_export"><span>CSV</span></button>
                            <button class="btn btn-primary mr-1" tabindex="0"
                                    aria-controls="file_export"><span>Excel</span></button>
                            <button class="btn btn-primary mr-1" tabindex="0"
                                    aria-controls="file_export"><span>PDF</span></button>
                            <button class="btn btn-primary mr-1" tabindex="0"
                                    aria-controls="file_export"><span>Print</span></button>
                        </div>
                        <div id="file_export_filter"><label>Search:<input type="search"
                                                                          class="form-control mb-2 form-control-sm"
                                                                          placeholder=""
                                                                          aria-controls="file_export"></label>
                        </div>
                        <table  class="table table-bordered nowrap display dataTable no-footer"
                                role="grid" aria-describedby="file_export_info" id="example">
                            <thead id="file_export">
                            <tr role="row">
                                <th scope="col">#</th>
                                <th scope="col">Naam</th>
                                <th scope="col">Username</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Tel</th>
                                <th scope="col">Function</th>
                                <th scope="col">Started</th>
                                <th scope="col">Salary</th>
                                <th scope="col"> Actions</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user):
                                $sql_rol = 'SELECT role_id FROM user_roles WHERE user_id = :id';
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindValue(':id',$this->id);
                                $stmt->execute();

                                $user_roles =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                                ?>
                                <tr role="row">
                                    <td class="sorting_1">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                   id="customControlValidation2" required="">
                                            <label class="form-check-label" for="customControlValidation2"></label>
                                        </div>
                                    </td>

                                    <td><?php echo $user['first_name'] ; ?></td>

                                    <td><?php echo $user['username'] ; ?></td>
                                    <td><a href="mailto:lorem@ipsum.be"></a>lorem@ipsum.be</td>
                                    <td><a href="tel:123456789"></a>+123 456 789</td>
                                   <?php foreach($user_roles as $user_role): ;
                                       $sql_rol_name = 'SELECT role FROM roles WHERE id =' . $user_role['role_id'];
                                       $statement_rol_name = $pdo->query($sql_rol_name);
                                       $user_role_array =  $statement_rol_name->fetchAll(PDO::FETCH_ASSOC);

                                   ?>

                                        <td><span class="badge rounded-pill bg-success text-white"><?= $user_role_array[0]['role']?></span></td>
                                    <?php endforeach; ?>
                                    <td>12-10-2014</td>
                                    <td>$1200</td>
                                    <td><a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning"><i class="far fa-edit"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include("includes/footer.php");
?>




