<?php
if(isset($pagination)):
$page = 1;
?>
    <div class="wpp-pagination">
        <ul class="list-group">
            <?php while($page <= $pagination->pages): ?>
                <li class="list-group-item">
                    <a href="<?php echo site_url($pagination->basePath); ?>/<?php echo $page; ?>" title="" style="color:<?php echo ($page == $pagination->page ? 'red' : '') ?>">
                        <?php echo $page; $page++; ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <br/>
<?php endif; ?>