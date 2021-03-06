<?php
defined('C5_EXECUTE') or die("Access Denied.");
$cID = $c->getCollectionID();
?>

<section class="ccm-ui">
	<header><?php echo t('Composer - %s', $pagetype->getPageTypeDisplayName())?></header>
	<form method="post" data-panel-detail-form="compose">
		<?php echo Loader::helper('concrete/ui/help')->display('panel', '/page/composer')?>

		<?php Loader::helper('concrete/composer')->display($pagetype, $c); ?>
	</form>

	<div class="ccm-panel-detail-form-actions dialog-buttons">
		<?php Loader::helper('concrete/composer')->displayButtons($pagetype, $c); ?>
	</div>
</section>

<script type="text/javascript">
ConcretePageComposerDetail = {

	timeout: 5000,
	saving: false,
	interval: false,
	$form: $('form[data-panel-detail-form=compose]'),

	saveDraft: function(onComplete) {
		var my = this;
		my.$form.concreteAjaxForm({
    		'beforeSubmit': function() {
    			my.saving = true;
    		},
			url: '<?php echo $controller->action('autosave')?>',
			success: function(r) {
				my.saving = false;
		        $('#ccm-page-type-composer-form-save-status').html(r.message).show();
		        if (onComplete) {
		        	onComplete(r);
		        }
			}
		}).submit();
	},

	enableAutosave: function() {
		this.saver.resetIdleTimer();
	},

	disableAutosave: function() {
		this.saver.disableIdleTimer();
	},

	updateWatchers: function() {
		var newElements = this.$form.find('button,input,keygen,output,select,textarea').not(this.watching),
			my = this;

		if (!this.watching.length) {
			newElements = newElements.add(this.$form);
		}

		this.watching = this.watching.add(newElements);

		newElements.bind('change', function() {
			my.saver.requestSave();
		});

		newElements.bind('keyup', function() {
			my.saver.requestSave(true);
		});
	},

	start: function() {
		var my = this;
		this.watching = $();
		my.updateWatchers();

		this.saver = this.$form.saveCoordinator(function(coordinater, data, success) {
			my.updateWatchers();
			my.saveDraft(function() {
				success();
			});
		},{
			idleTimeout: 1
		}).data('SaveCoordinator');

	    $('button[data-page-type-composer-form-btn=discard]').on('click', function() {
			if (confirm('<?php echo t('This will remove this draft and it cannot be undone. Are you sure?')?>')) {
		    	my.disableAutosave();
		    	$.concreteAjax({
		    		'url': '<?php echo $controller->action('discard')?>',
		    		'data': {cID: '<?php echo $cID?>'},
		    		success: function(r) {
						window.location.href = r.redirectURL;
		    		}
		    	});
			}
		});

	    $('button[data-page-type-composer-form-btn=preview]').on('click', function() {
	    	my.disableAutosave();
	    	redirect = function () {
	   			window.location.href = CCM_DISPATCHER_FILENAME + '?cID=<?php echo $cID?>&ctask=check-out&<?php echo Loader::helper('validation/token')->getParameter()?>';
	    	}
	    	if (!my.saving) {
	    		my.saveDraft(redirect);
	    	} else {
	    		redirect();
	    	}
		});

        $('button[data-page-type-composer-form-btn=exit]').on('click', function() {
            my.disableAutosave();
            var submitSuccess = false;
            my.$form.concreteAjaxForm({
                url: '<?php echo $controller->action('save_and_exit')?>',
                success: function(r) {
                    submitSuccess = true;
                    window.location.href = r.redirectURL;
                },
                complete: function() {
                    if (!submitSuccess) {
                        my.enableAutosave();
                    }
                    jQuery.fn.dialog.hideLoader();
                }
            }).submit();
        });

		$('button[data-page-type-composer-form-btn=publish]').on('click', function() {
			var data = my.$form.serializeArray();
			ConcreteEvent.fire('PanelComposerPublish', {data: data});
		});

		ConcreteEvent.subscribe('PanelCloseDetail',function(e, panelDetail) {
			if (panelDetail && panelDetail.identifier == 'page-composer') {
				my.disableAutosave();
			}
		});

		ConcreteEvent.subscribe('PanelComposerPublish',function(e, data) {

			my.disableAutosave();
			var submitSuccess = false;
			$.concreteAjax({
				data: data.data,
				url: '<?php echo $controller->action('publish')?>',
				success: function(r) {
					submitSuccess = true;
					window.location.href = r.redirectURL;
				},
				complete: function() {
					if (!submitSuccess) {
						my.enableAutosave();
					}
					jQuery.fn.dialog.hideLoader();
				}
			});
		});

		ConcreteEvent.subscribe('AjaxRequestError',function(r) {
			my.saver.disable();
		});

		this.saver.enable();
	    my.enableAutosave();
	}

}

$(function() {
	ConcretePageComposerDetail.start();
});
</script>
