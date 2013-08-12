<?php get_header() ?>
<div class="container-fluid">
		<header class="title">
			<h2><?php the_title() ?></h2>
		</header>
		<?php while ( have_posts() ) : the_post(); ?>
	
		<div class="post">
				<div class="row-fluid">	
					<article>
						<?php the_content() ?>
					</article>
				</div>
				<div class="row-fluid">	
					<div class="share">
						<ul>
<!-- 							<li>
								<a href="#" title="share on facebook">
									<i class="icon-facebook"></i>
								</a>
							</li> -->
							<li>
								<a href="http://twitter.com/raulsann" title="Tweet" target="_blank">
									<i class="icon-twitter"></i>
								</a>
							</li>
							<li>
								<a href="https://plus.google.com/113853082104029695167" title="Post on Google plus" target="_blank">
									<i class="icon-google-plus"></i>
								</a>
							</li>
							<li>
								<a href="http://www.linkedin.com/in/raulsann" title="Post on Linkedin" target="_blank">
									<i class="icon-linkedin"></i>
								</a>
							</li>
<!-- 							<li>
								<a href="#" title="Pin it">
									<i class="icon-pinterest"></i>
								</a>
							</li> -->
						</ul>
					</div>
					<?php endwhile; ?>
				</div>
			</div>
		
	</div>	
	
<?php get_footer() ?>