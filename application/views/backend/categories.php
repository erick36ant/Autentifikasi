			<h1><?=$title;?></h1>

			<!-- Table (TABLE) -->
			<br />
			<?php
			   echo anchor(site_url('backend/categories/form/insert/'),'Add',' class="input-submit"');	
			?>
			<br />
			<table>
				<tr>
					<th>No</th>
					<th>Actions</th>					    
				    <th>Categories Name</th>
				    <th>Description</th>	
					<th>Picture</th>	
				</tr>
				<?php
					$no=0;
					foreach($array_categories as $row):	
					$id=$row->CategoryID;	
					$no++;	
					$css=($no%2==1)? '' : 'class="bg"';
				?>
				<tr <?=$css;?> >
					<td><?=$no;?>.</td>
				    <td><?=anchor(site_url('backend/categories/process/delete/'.$id),'[delete]').' | '.
				    	   anchor(site_url('backend/categories/form/update/'.$id),'[update]');?></td>				    
				    <td><?=$row->CategoryName;?></td>
				    <td><?=$row->Description;?></td>	
					<td><?=$row->Picture;?></td>
				</tr>
				<?php  endforeach; ?>
			</table>

		