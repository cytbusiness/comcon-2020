<?php
  // Print download results to the page - prefix argument is used to differentiate
  // results from search and default listings so that the toggles don't conflict
  function printDownload($prefix, $article)
  {
    // Joomla includes since we're outside the Joomla platform here
    if (!defined('_JEXEC')) { define('_JEXEC', 1); }
    if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
    if (!defined('JPATH_BASE')) { define('JPATH_BASE', realpath(dirname(__FILE__, 5))); }
    require_once JPATH_BASE . DS . 'includes/defines.php';
    require_once JPATH_BASE . DS . 'includes/framework.php';
    require_once JPATH_BASE . DS . 'components/com_content/helpers/route.php';

    // Custom function
    require_once JPATH_BASE . DS . 'templates/comcon-2019/includes/functions/article.php';
    require_once JPATH_BASE . DS . 'templates/comcon-2019/includes/functions/functions.php';

    $rootURL = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $rootURL .= $_SERVER['SERVER_NAME'];

    // Create the Application
    $app = JFactory::getApplication('site');

    $images   = json_decode($article->images);
    $attribs  = json_decode($article->attribs);

    $downloads = getDownloads($article);

    if ($downloads !== null)
    {
      if (!empty($downloads->brochures) || !empty($downloads->specs) || !empty($downloads->installs) || !empty($downloads->cads)) :
?>
<article class="dl-result">
  <input type="checkbox" class="dl-result__checkbox" id="toggle-<?php echo $prefix; ?>-<?php echo $article->id; ?>">
  <label for="toggle-<?php echo $prefix; ?>-<?php echo $article->id; ?>" class="dl-result__label">
    <h3 class="dl-result__title text__xsheading"><?php echo $article->title; ?></h3>
    <span class="dl-result__btn">&nbsp;</span>
  </label>
  <div class="dl-result__body">
    <div class="dl-result__intro">
      <img src="<?php echo $rootURL . DS . $images->image_intro; ?>" alt="<?php echo $article->title; ?>" class="dl-result__image">
      <div class="dl-result__introcontent">
        <div class="dl-result__introtext">
          <p class="text__line"><?php echo $attribs->alternative_readmore; ?></p>
        </div>
        <a href="<?php echo getArticleURL($article); ?>" class="dl-result__product text__line link-text">Visit product page.</a>
      </div>
    </div>
    <div class="dl-result__content">

      <?php if (!empty($downloads->brochures)) : ?>
      <h4 class="text__xsheading">Product Brochures</h4>
      <ul class="dl-result__items">
        <?php foreach ($downloads->brochures as $key => $brochure) : ?>
        <li class="dl-result__item">
          <a href="<?php echo rootUrl() . DS . $brochure; ?>" class="dl-result__link link-fill" target="_blank">
            <div class="dl-result__icon">
              <div class="dl-result__icontext"><?php echo getDownloadExt(rootUrl() . $brochure); ?></div>
            </div>
            <div class="dl-result__text">
              <p class="text__cta"><?php echo $downloads->brochure_titles[$key]; ?></p>
              <p class="text__cta"><?php echo getFileSize(JPATH_BASE . DS . $brochure); ?></p>
            </div>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif ?>

      <?php if (!empty($downloads->specs)) : ?>
      <h4 class="text__xsheading">Technical Specifications</h4>
      <ul class="dl-result__items">
        <?php foreach ($downloads->specs as $key => $spec) : ?>
          <li class="dl-result__item">
            <a href="<?php echo rootUrl() . DS . $spec; ?>" class="dl-result__link link-fill" target="_blank">
              <div class="dl-result__icon">
                <div class="dl-result__icontext"><?php echo getDownloadExt(rootUrl() . $spec); ?></div>
              </div>
              <div class="dl-result__text">
                <p class="text__cta"><?php echo $downloads->specs_titles[$key]; ?></p>
                <p class="text__cta"><?php echo getFileSize(JPATH_BASE . DS . $spec); ?></p>
              </div>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>

      <?php if (!empty($downloads->installs)) : ?>
      <h4 class="text__xsheading">Installation Guides</h4>
      <ul class="dl-result__items">
        <?php foreach ($downloads->installs as $key => $install) : ?>
          <li class="dl-result__item">
            <a href="<?php echo rootUrl() . DS . $install; ?>" class="dl-result__link link-fill" target="_blank">
              <div class="dl-result__icon">
                <div class="dl-result__icontext"><?php echo getDownloadExt(rootUrl() . $install); ?></div>
              </div>
              <div class="dl-result__text">
                <p class="text__cta"><?php echo $downloads->installs_titles[$key]; ?></p>
                <p class="text__cta"><?php echo getFileSize(JPATH_BASE . DS . $install); ?></p>
              </div>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>

      <?php if (!empty($downloads->cads)) : ?>
      <h4 class="text__xsheading">CAD Models</h4>
      <ul class="dl-result__items">
        <?php foreach ($downloads->cads as $key => $cad) : ?>
          <li class="dl-result__item">
            <a href="<?php echo rootUrl() . DS . $cad; ?>" class="dl-result__link link-fill" target="_blank">
              <div class="dl-result__icon">
                <div class="dl-result__icontext"><?php echo getDownloadExt(rootUrl() . $cad); ?></div>
              </div>
              <div class="dl-result__text">
                <p class="text__cta"><?php echo $downloads->cads_titles[$key]; ?></p>
                <p class="text__cta"><?php echo getFileSize(JPATH_BASE . DS . $cad); ?></p>
              </div>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</article>
<?php
      endif;
    }
  }
?>
