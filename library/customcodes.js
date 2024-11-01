//////////////////////////////////////////////////////////////////
// Add wpil Button
//////////////////////////////////////////////////////////////////


(function() {  
    tinymce.create('tinymce.plugins.wpil', {  
        init : function(ed, url) {  
            ed.addButton('wpil', {  
                title : 'Add Inner Link',  
                image : url+'/icons/link.png',  
                onclick : function() {  
                     ed.selection.setContent('[wpil posttype="post" link_text=" " title=" "]');  
  
                }  
            });  
        },  
       
        createControl : function(n, cm) {  
            return null;  
        },  
    });  

    tinymce.PluginManager.add('wpil', tinymce.plugins.wpil);  
})();