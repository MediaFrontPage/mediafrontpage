var widgets = {
    
    jQuery : $,
    
    settings : {
        sections : '.section',
        widgetSelector: '.widget',
        handleSelector: '.widget-head',
        contentSelector: '.widget-content',
        
        widgetDefault : {
            movable: true,
            removable: true,
            collapsible: true,
            editable: true,
        },
        widgetIndividual : {}
    },

    init : function () {
        this.sortWidgets();
        this.addWidgetControls();
        this.makeSortable();
    },
    
    getWidgetSettings : function (id) {
        var $ = this.jQuery,
            settings = this.settings;
        return (id&&settings.widgetIndividual[id]) ? $.extend({},settings.widgetDefault,settings.widgetIndividual[id]) : settings.widgetDefault;
    },
    
    addWidgetControls : function () {
        var widgets = this,
            $ = this.jQuery,
            settings = this.settings;
            
        $(settings.widgetSelector, $(settings.sections)).each(function () {
            var thisWidgetSettings = widgets.getWidgetSettings(this.id);
            if (thisWidgetSettings.removable) {
                $('<a href="#" class="remove">CLOSE</a>').mousedown(function (e) {
                    // STOP event bubbling
                    e.stopPropagation();    
                }).click(function () {
                    if(confirm('This widget will be removed, ok?')) {
                        $(this).parents(settings.widgetSelector).animate({
                            opacity: 0    
                        },function () {
                            $(this).wrap('<div/>').parent().slideUp(function () {
                                $(this).remove();
                            });
                        });
                    }
                    return false;
                }).appendTo($(settings.handleSelector, this));
            }
            
       /*    if (thisWidgetSettings.editable) {
                $('<a href="#" class="edit">EDIT</a>').mousedown(function (e) {
                    // STOP event bubbling 
                    e.stopPropagation();    
                }).toggle(function () {
                    $(this).css({backgroundPosition: '-66px 0', width: '42px'})
                        .parents(settings.widgetSelector)
                            .find('.widget-config').show().find('input').focus();
                    return false;
                },function () {
                    $(this).css({backgroundPosition: '', width: '24px'})
                        .parents(settings.widgetSelector)
                            .find('.widget-config').hide();
                    return false;
                }).appendTo($(settings.handleSelector,this));
                $('<div class="widget-config" style="display:none;"/>')
                    .append('<ul><li class="item"><label>Title:</label><input value="' + $('h3',this).text() + '"/></li>')
                    .append('</ul>')
                    .insertAfter($(settings.handleSelector,this));
            }*/
            
            if (thisWidgetSettings.collapsible) {
                $('<a href="#" class="collapse">COLLAPSE</a>').mousedown(function (e) {
                    /* STOP event bubbling */
                    e.stopPropagation();    
                }).click(function(){
                    $(this).parents(settings.widgetSelector).toggleClass('collapsed');
                    /* Save prefs: */
                    widgets.savePreferences();
                    return false;    
                }).prependTo($(settings.handleSelector,this));
            }
        });
        
        $('.widget-config').each(function () {
            $('input',this).keyup(function () {
                $(this).parents(settings.widgetSelector).find('h3').text( $(this).val().length>20 ? $(this).val().substr(0,20)+'...' : $(this).val() );
                widgets.savePreferences();
            });
        });
        
    },
    
    attachStylesheet : function (href) {
        var $ = this.jQuery;
        return $('<link href="' + href + '" rel="stylesheet" type="text/css" />').appendTo('head');
    },
    
    makeSortable : function () {
        var widgets = this,
            $ = this.jQuery,
            settings = this.settings,
            $sortableItems = (function () {
                var notSortable = '';
                $(settings.widgetSelector,$(settings.sections)).each(function (i) {
                    if (!widgets.getWidgetSettings(this.id).movable) {
                        if(!this.id) {
                            this.id = 'widget-no-id-' + i;
                        }
                        notSortable += '#' + this.id + ',';
                    }
                });
                return $('> li:not(' + notSortable + ')', settings.sections);
            })();
        
        $sortableItems.find(settings.handleSelector).css({
            cursor: 'move'
        }).mousedown(function (e) {
            $sortableItems.css({width:''});
            $(this).parent().css({
                width: $(this).parent().width() + 'px'
            });
        }).mouseup(function () {
            if(!$(this).parent().hasClass('dragging')) {
                $(this).parent().css({width:''});
            } else {
                $(settings.sections).sortable('disable');
            }
        });

        $(settings.sections).sortable({
            items: $sortableItems,
            connectWith: $(settings.sections),
            handle: settings.handleSelector,
            placeholder: 'widget-placeholder',
            forcePlaceholderSize: true,
            revert: 300,
            delay: 100,
            opacity: 0.8,
            containment: 'document',
            start: function (e,ui) {
                $(ui.helper).addClass('dragging');
            },
            stop: function (e,ui) {
                $(ui.item).css({width:''}).removeClass('dragging');
                $(settings.sections).sortable('enable');
                /* Save prefs: */
                widgets.savePreferences();
            }
        });
    },
    
    savePreferences : function () {
        var widgets = this,
			$ = this.jQuery,
			settings = this.settings,
			arrLayout = '';
		var jsonLayout = '';
			var p = 1;
			
        // Assemble the layout array in json
        $(settings.sections).each(function(i){
            jsonLayout += (i===0) ? '{ "method" : "SaveLayout", "params" : { "section'+(i+1)+'" : { ' : ', "section'+(i+1)+'" : { ';
            $(settings.widgetSelector,this).each(function(i){
                jsonLayout += (i===0) ? '"' : ', "';


                jsonLayout += 'position'+p+'" : { ';
		p++;

                // ID of widget:
                jsonLayout += '"id" : "'+$(this).attr('id')+'", "title" : "';

                // Title of widget (replaced used characters)
                jsonLayout += $('h3:eq(0)',this).text().replace(/\|/g,'[-PIPE-]').replace(/,/g,'[-COMMA-]') + '", "display" : "';

                // Collapsed/not collapsed widget? :
                jsonLayout += $(settings.contentSelector,this).css('display') === 'none' ? 'collapsed" }' : '" }';
            });
            jsonLayout += ' }';
        });
		jsonLayout += ' } }';
		
		// Call json service to save the layout.
        var jsonResponse = "";
		$.post("jsonservice.php", jsonLayout, function(jsonResponse) {
			if(jsonResponse.error) {
				alert ('Problem saving layout file.\n\nError: '+jsonResponse.error.message);
			}
		}, "json");
    },
    
    sortWidgets : function () {
        var widgets = this,
            $ = this.jQuery,
            settings = this.settings;
    }
  
};

widgets.init();
