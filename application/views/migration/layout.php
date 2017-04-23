<?php foreach($results as $result): ?>
    <p>
        <span>Migration: </span>
        <strong><?php echo $result['name'] ?></strong>
        <span>Status:
            <?php
                if($result['success']) {
                    echo 'success';
                }
                else {
                    echo 'fail';
                }
            ?>
        </span>
        <span>Type: <?php echo $result['type'] ?></span>
    </p>
<?php endforeach; ?>
