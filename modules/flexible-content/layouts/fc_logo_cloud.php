<?php
/**
 * Logo Cloud
 */

$bubbles = get_sub_field('logos');
$bubbles_last = end($bubbles);
$canvas_width = isset($bubbles_last['coordinates']['x']) ? (int)$bubbles_last['coordinates']['x'] + 200 : 0;

if(!empty($bubbles) && $canvas_width):
$coors = array();

for ($i = 0; $i < 2; $i++) {
    foreach($bubbles as $bubble) {
        $coordinates = $bubble['coordinates'];

        $x = (float)$coordinates['x'];
        $y = (float)$coordinates['y'];
        $s = $coordinates['s'];

        $coors[] = array(
            'x' => $i == 1 ? ($canvas_width + $x + 100) : $x,
            'y' => $y,
            's' => $s
        );
    }
}
?>

<div class="bubble-wrap">
    <div class="bubbles" data-coors='<?php echo json_encode($coors); ?>' data-canvas-width="<?php echo $canvas_width; ?>">
        <?php 
            $bubble_count = 1;
            for ($i = 0; $i < 2; $i++):
                foreach($bubbles as $bubble):
        ?>
                <div class="bubble logo<?php echo $bubble_count; ?>">
                    <img src="<?php echo $bubble['logo']; ?>">
                </div>
        <?php 
                $bubble_count++; endforeach;
            endfor;
        ?>
    </div>
</div>
<?php endif; ?>