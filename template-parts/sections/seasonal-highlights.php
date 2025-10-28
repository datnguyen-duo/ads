<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$rows = get_sub_field('rows');
?>
<h2 class="<?php echo $layout . '__heading text__size-3'; ?>">Seasonal Highlights</h2>
<?php if ($rows): ?>
    <table class="<?php echo $layout . '__table'; ?>">
        <thead>
            <tr>
                <th class="text__size-body--sm">Month</th>
                <th class="text__size-body--sm">Season</th>
                <th class="text__size-body--sm">Weather</th>
                <th class="text__size-body--sm">Wildlife Sightings</th>
                <th class="text__size-body--sm">Rec.</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): 
                $recommended = $row['recommended'];
                $month = $row['month'];
                $season = $row['season'];
                $weather = $row['weather'];
                $wildlife_sightings = $row['wildlife_sightings'];
                ?>
                <tr class="<?php echo $recommended ? '--recommended' : ''; ?>">
                    <td class="text__size-body--sm"><?php echo $month; ?></td>
                    <td class="text__size-body--sm"><?php echo $season; ?></td>
                    <td class="text__size-body--sm"><?php echo $weather; ?></td>
                    <td class="text__size-body--sm"><?php echo $wildlife_sightings; ?></td>
                    <td class="text__size-body--sm --recommended"><?php echo $recommended ? 'Yes' : 'No'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>