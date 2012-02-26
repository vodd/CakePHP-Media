<?php $sizes = getimagesize(IMAGES.$v['file']);  ?>
<div class="item">
	<input type="hidden" value="<?php echo $v['position']; ?>" name="data[Media][<?php echo $v['id']; ?>]">
	<div class="visu"><?php echo $this->Html->image($v['file']) ?></div>
	<?php echo basename($v['file']); ?>
	<div class="actions">
		<?php echo $this->Html->link("Supprimer",array('action'=>'delete',$v['id']),array('class'=>'del')); ?> - 
		<a href="#" class="toggle">Afficher</a>
	</div>
	<div class="expand">
		<table>
			<tr>
				<td style="width:140px"><?php echo $this->Html->image($v['file']) ?></td>
				<td>
					<p><strong>Nom du fichier :</strong> <?php echo basename($v['file']); ?></p>
					<p><strong>Taille de l'image :</strong> <?php echo $sizes[0].'x'.$sizes[1]; ?></p>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td style="width:140px"><label>Titre</label></td>
				<td><input id="title" name="title" type="text"></td>
			</tr>
			<tr>
				<td style="width:140px"><label>Texte alternatif</label></td>
				<td><input id="alt" name="alt" type="text"></td>
			</tr>
			<tr>
				<td style="width:140px"><label>Cible du lien</label></td>
				<td><input id="href" name="href" type="text"></td>
			</tr>
			<tr>
				<td style="width:140px"><label>Alignement</label></td>
				<td>
					<input type="radio" name="align" id="align-none"><?php echo $this->Html->image('/media/img/align-none.png'); ?><label for="align-none">Aucun</label>
					<input type="radio" name="align" id="align-left"><?php echo $this->Html->image('/media/img/align-left.png'); ?><label for="align-left">Gauche</label>
					<input type="radio" name="align" id="align-center"><?php echo $this->Html->image('/media/img/align-center.png'); ?><label for="align-center">Centre</label>
					<input type="radio" name="align" id="align-right"><?php echo $this->Html->image('/media/img/align-right.png'); ?><label for="align-right">Droite</label>
				</td>
			</tr>
			<tr>
				<td style="width:140px"> &nbsp; </td>
				<td>
					<p><a href="" class="submit">Insérer dans l'article</a> <?php echo $this->Html->link("Supprimer",array('action'=>'delete',$v['id']),array('class'=>'del')); ?></p>
				</td>
			</tr>
		</table>
	</div>
</div>