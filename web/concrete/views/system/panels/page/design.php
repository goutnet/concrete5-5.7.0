<?
defined('C5_EXECUTE') or die("Access Denied.");
?>
<section id="ccm-panel-page-design">
<form method="post" action="<?=$controller->action('submit')?>" data-panel-detail-form="design">
	<input type="hidden" name="update_theme" value="1" class="accept">
	<input type="hidden" name="processCollection" value="1">


	<header><a href="" data-panel-navigation="back" class="ccm-panel-back"><span class="glyphicon glyphicon-chevron-left"></span></a> <?=t('Design')?></header>

	<div class="ccm-panel-content-inner">

	<? if ($cp->canEditPageTemplate() && !$c->isGeneratedCollection()) { ?>
		<div class="list-group" id="ccm-panel-page-design-page-types" data-panel-menu-id="page-templates" data-panel-menu="collapsible-list-group">
			<div class="list-group-item list-group-item-header"><?=t('Page Template')?></div>
			<?
			foreach($templates as $tmp) {
				$selected = false;
				if (is_object($selectedTemplate) && $tmp->getPageTemplateID() == $selectedTemplate->getPageTemplateID()) { 
					$selected = true;
				} 
				?>
				<label class="list-group-item"><input type="radio" value="<?=$tmp->getPageTemplateID()?>" name="pTemplateID" <? if ($selected) { ?>checked<? } ?> /> <?=$tmp->getPageTemplateName()?>
					<?=$tmp->getPageTemplateIconImage()?>
				</label>
				<? if ($selected) { ?>
					<div class="list-group-item-collapse-wrapper">
				<? } ?>
			<? } ?>

			<? if ($selectedTemplate) { ?>
				</div>
			<? } ?>
			<a class="list-group-item list-group-item-collapse" href="#"><span><?=t('Expand')?></span></a>
		</div>
	<? } ?>

	<? if ($cp->canEditPageTheme()) { ?>
		<div id="ccm-panel-page-design-themes" class="list-group" data-panel-menu-id="themes" data-panel-menu="collapsible-list-group">
			<input type="hidden" name="pThemeID" value="<?=$selectedTheme->getThemeID()?>" />

			<div class="list-group-item list-group-item-header"><?=t('Theme')?>
			<? if (ENABLE_MARKETPLACE_SUPPORT) { ?>
				<div class="ccm-marketplace-btn-wrapper">
				<button onclick="ccm_openThemeLauncher()" class="btn-ccm-marketplace btn btn-large"><?=t("Install More Themes")?></button>
				</div>
			<? } ?>
			</div>
			<?
			foreach($themes as $th) {
				$selected = false;
				if (is_object($selectedTheme) && $th->getThemeID() == $selectedTheme->getThemeID()) { 
					$selected = true;
				}
				?>
				<div data-theme-id="<?=$th->getThemeID()?>" class="list-group-item ccm-page-design-theme-thumbnail <? if ($selected) { ?>ccm-page-design-theme-thumbnail-selected<? } ?> ">
					<span><i><?=$th->getThemeThumbnail()?>
						<? if ($th->isThemeCustomizable()) { ?>
						<span class="ccm-page-design-theme-customize">
							<?=t('Customize')?>
							<a href="#" data-launch-sub-panel-url="<?=URL::to('/system/panels/page/design/customize', $th->getThemeID())?>"><i class="glyphicon glyphicon-share-alt"></i></a>
						</span>
						<? } ?>
					</i>
					<div class="ccm-panel-page-design-theme-description"><h4><?=$th->getThemeName()?></h4></div>

					</span>
				</div>
				<? if ($selected) { ?>
					<div class="list-group-item-collapse-wrapper">
				<? } ?>
			<? } ?>

			<? if ($selectedTheme) { ?>
				</div>
			<? } ?>
			<a class="list-group-item list-group-item-collapse" href="#"><span><?=t('Expand')?></span></a>
		</div>
	<? } ?>

	</div>
</form>

</section>

	<div class="ccm-panel-detail-form-actions">
		<button class="pull-right btn btn-success" type="button" data-panel-detail-action="submit"><?=t('Save Changes')?></button>
	</div>

<script type="text/javascript">
$(function() {

	function swapElements(elm1, elm2) {
	    var parent1, next1,
	        parent2, next2;

	    parent1 = elm1.parentNode;
	    next1   = elm1.nextSibling;
	    parent2 = elm2.parentNode;
	    next2   = elm2.nextSibling;

	    parent1.insertBefore(elm2, next1);
	    parent2.insertBefore(elm1, next2);
	}

	ccm_event.subscribe('collapse.page-templates', function(e) {
		/* We find the selected page type. If it's not the first one, we make it the first one and swap that one. */
		var $topitem = $('#ccm-panel-page-design-page-types > label.list-group-item input[type=radio]');
		var $checkeditem = $('#ccm-panel-page-design-page-types input[type=radio]:checked');
		if (!$topitem.is(':checked')) {
			swapElements($checkeditem.parent()[0], $topitem.parent()[0]);
		}
	});

	$('.list-group-item[data-theme-id]').on('click', function() {
		$('#ccm-panel-page-design-themes input[name=pThemeID]').val($(this).attr('data-theme-id')).trigger('change');
		$('.ccm-page-design-theme-thumbnail-selected').removeClass('ccm-page-design-theme-thumbnail-selected');
		$(this).addClass('ccm-page-design-theme-thumbnail-selected');
	});

	ccm_event.subscribe('collapse.themes', function(e) {
		/* We find the selected page type. If it's not the first one, we make it the first one and swap that one. */
		var $topitem = $('#ccm-panel-page-design-themes > div.list-group-item[data-theme-id]');
		var $checkeditem = $('#ccm-panel-page-design-themes .ccm-page-design-theme-thumbnail-selected');
		if ($topitem.attr('data-theme-id') != $checkeditem.attr('data-theme-id')) {
			swapElements($checkeditem[0], $topitem[0]);
		}
	});

	$('#ccm-panel-page-design input[name=pThemeID], #ccm-panel-page-design input[name=pTemplateID]').on('change', function() {
		var pThemeID = $('#ccm-panel-page-design input[name=pThemeID]').val();
		var pTemplateID = $('#ccm-panel-page-design input[name=pTemplateID]:checked').val();
		var src = '<?=$controller->action("preview_contents")?>&pThemeID=' + pThemeID + '&pTemplateID=' + pTemplateID;
		$('#ccm-page-preview-frame').get(0).src = src;
	});

});
</script>