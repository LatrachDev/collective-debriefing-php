<?php include __DIR__.'/../layouts/header.php'; ?>
<?php include __DIR__.'/../../database/connection.php'; ?>
<?php 
session_start();
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1){
    header("Location: /views/auth/login.php");
}
try {
    $stmt = $conn->prepare("SELECT * FROM User");
    $stmt->execute();
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    throw new Exception("Failed to get users: " . $e->getMessage());
}

?>
<h2>Admin Dashboard</h2>


<!-- Add User Button -->
<a href="./users/add.php" class="btn btn-primary mb-3">Add User</a>


<!-- TODO: Display a table of users with options to edit or delete -->
<!-- Use Bootstrap table classes -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Fullname</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        
    <?php foreach($users as $user): ?>
        <tr>
            <td><?=$user['id']?></td>
            <td><?=$user['username']?></td>
            <td><?=$user['fullname']?></td>
            <td><?php echo $user['role_id'] == 1 ? 'Admin' : 'User'; ?></td>
            <td>
                <a href='./users/edit.php?id=<?=$user['id']?>' class='btn btn-warning'>Edit</a>
                <a href='./users/delete.php?id=<?=$user['id']?>' class='btn btn-danger'>Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
       
    </tbody>
</table>

<?php include __DIR__.'/../layouts/footer.php'; ?>