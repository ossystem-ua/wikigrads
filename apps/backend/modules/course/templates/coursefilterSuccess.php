<?php foreach ($result as $record):?>
    <?php if ($type == 1): ?>
        <option value="<?php echo $record["id"]; ?>" <?php if ($record["id"] == $userId): ?>selected="selected"<?php endif; ?>><?php echo $record["name"]; ?></option>
    <?php endif; ?>
    <?php if ($type == 2): ?>
        <option value="<?php echo $record["id"]; ?>" <?php if ($record["id"] == $userId): ?>selected="selected"<?php endif; ?>><?php echo $record["first_name"]." ".$record["last_name"]." (".$record["email_address"].")"; ?></option>
    <?php endif; ?>
<?php endforeach; ?>
