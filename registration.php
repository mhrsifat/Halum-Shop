<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_registration = $row['banner_registration'];
}
?>

<?php
if (isset($_POST['form1'])) {
    // [Validation and processing code remains unchanged]
}
?>
<style>
    .d-none {
        display: none !important;
    }
</style>
<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_registration; ?>);">
    <div class="inner">
        <h1><?php echo LANG_VALUE_16; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <?php
                                if ($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $error_message . "</div>";
                                }
                                if ($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $success_message . "</div>";
                                }
                                ?>
                                
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_102; ?> *</label>
                                    <input type="text" class="form-control" name="cust_name" value="<?php if (isset($_POST['cust_name'])) { echo $_POST['cust_name']; } ?>">
                                </div>
                                <div class="col-md-6 form-group HideForBD">
                                    <label for=""><?php echo LANG_VALUE_103; ?></label>
                                    <input type="text" class="form-control" name="cust_cname" value="<?php if (isset($_POST['cust_cname'])) { echo $_POST['cust_cname']; } ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_94; ?> *</label>
                                    <input type="email" class="form-control" name="cust_email" value="<?php if (isset($_POST['cust_email'])) { echo $_POST['cust_email']; } ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_104; ?> </label>
                                    <input type="text" class="form-control" name="cust_phone" value="<?php if (isset($_POST['cust_phone'])) { echo $_POST['cust_phone']; } ?>">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for=""><?php echo LANG_VALUE_105; ?> </label>
                                    <textarea name="cust_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php if (isset($_POST['cust_address'])) { echo $_POST['cust_address']; } ?></textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_106; ?> *</label>
                                    <select name="cust_country" class="form-control select2" id="country">
                                        <option value="">Select country</option>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                        ?>
                                            <option
                                                value="<?php echo $row['phone_code']; ?>"
                                                <?= ($row['country_name'] == 'Bangladesh') ? 'selected="selected"' : '' ?>>
                                                <?php echo $row['country_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_107; ?> </label>
                                    <input type="text" class="form-control" name="cust_city" value="<?php if (isset($_POST['cust_city'])) { echo $_POST['cust_city']; } ?>">
                                </div>
                                <div class="col-md-6 form-group HideForBD">
                                    <label for=""><?php echo LANG_VALUE_108; ?> </label>
                                    <input type="text" class="form-control" name="cust_state" value="<?php if (isset($_POST['cust_state'])) { echo $_POST['cust_state']; } ?>">
                                </div>
                                <div class="col-md-6 form-group HideForBD">
                                    <label for=""><?php echo LANG_VALUE_109; ?> </label>
                                    <input type="text" class="form-control" name="cust_zip" value="<?php if (isset($_POST['cust_zip'])) { echo $_POST['cust_zip']; } ?>">
                                </div>
                                
                                <!-- Password fields grouped together -->
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_96; ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_98; ?> *</label>
                                    <input type="password" class="form-control" name="cust_re_password">
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-danger" value="<?php echo LANG_VALUE_15; ?>" name="form1">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

<script>
$(document).ready(function () {
    function toggleCity(){
        var countryVal = $('#country').val();
        if (countryVal == '880') { 
            $('.HideForBD').addClass('d-none');
            console.log('bd')
        } else {
            $('.HideForBD').removeClass('d-none');
            console.log('not bd')
        }
    }

    toggleCity(); // check on load
    $('#country').on('change', function () {
        toggleCity(); // check on change
    });
});
</script>