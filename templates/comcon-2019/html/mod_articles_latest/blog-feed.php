<?php

	defined('_JEXEC') or die;

?>
<aside class="blog-feed">
	<h3 class="text__subheading">Our latest blog posts</h3>
	<ul class="category__items<?php echo $moduleclass_sfx; ?> mod-list">
	<?php foreach ($list as $item) : ?>
		<?php $images = json_decode($item->images); ?>
		<li class="category__item" itemscope itemtype="https://schema.org/Article">
			<div class="category__imagebox">
				<?php
					$date = new DateTime($item->created);
			    echo "<time class=\"tag__date\" datetime=\"" . $date->format('Y-m-d') . "\">" . $date->format('d F Y') . "</time>\n";
				?>
				<a class="category__link link-fill" href="<?php echo $item->link; ?>" itemprop="url">
					<img src="<?php print_r($images->image_intro); ?>" alt="<?php echo htmlspecialchars($item->title); ?>" class="category__image">
				</a>
			</div>

			<div class="category__content">
				<h2 class="text__xsheading"><?php echo htmlspecialchars($item->title); ?></h2>
				<p class=\"text__line\">
				 <?php echo htmlspecialchars($item->alternative_readmore); ?>
			 	</p>
				<p class="category__label text__line\">
	       <a href="<?php echo $item->link; ?>" class="category__link link-fill">
	         Read More
	       </a>
	      </p>
			</div>
		</li>
	<?php endforeach; ?>
	</ul>
</aside>
