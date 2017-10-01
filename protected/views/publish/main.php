<div class="full_w">
	<div class="h_title">Management-Puslish-Package</div>
	
	<table style="width: 96%; impotant!">
		<thead>
			<tr>
				<th>#</th>
				<th>name</th>
				<th>Image</th>
				<th>version</th>
				<th class="no-sort"></th>
			</tr>
		</thead>
		<tbody>
	<?php
	$counter = 1;
	$dataProvider = $data->search ();
	
	foreach ( $dataProvider->data as $data ) {
		?>
				<tr class="line-<?php echo $counter%2 == 0 ? '1' : '2'?>">
				<td class="center"><?php echo  $counter;?></td>
				<td class="center"><?php echo $data->name?></td>
				<td class="center"><?php echo CHtml::image(Yii::app()->request->baseUrl."/images/".$data->image,"",array('width'=>48, 'height'=>48))?></td>
				<td class="center"><?php echo $data->version?></td>

				<td class="center">
				<a href="Publish/GeneratePackage/app_id/<?php echo $data->id;?>" class="button add">Publish</a>



				</td>
			</tr>
			<?php
		$counter ++;
	}
	?>
						</tbody>
	</table>
	<span>* ทุกครั้งที่มีมีการแก้ไขเนื้อหา ให้มากดปุ่ม publish เพื่อให้  Application ได้อัพเดท version ตาม</span>
	
</div>

<div class="clear"></div>
