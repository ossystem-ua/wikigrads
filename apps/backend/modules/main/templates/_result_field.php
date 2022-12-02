{
    "data":[
        { "value": "" }
        <?php foreach($records as $record): ?>
        ,{"value": "<?php echo $record; ?>"}
        <?php endforeach; ?>
    ],
    "success" : <?php echo $success; ?>,
    "source": {
        <?php foreach ($source as $key => $value): ?>
        "<?php echo $key; ?>": "<?php echo $value; ?>",
        <?php endforeach; ?>
        "success": "<?php echo $success; ?>"
    }
}

