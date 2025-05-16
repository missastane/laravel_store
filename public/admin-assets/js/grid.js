$(document).ready(function () {

   function removeAllSidebarToggleClass() {
      $('#sidebar-toggle-hide').removeClass('d-md-inline');
      $('#sidebar-toggle-hide').removeClass('d-none');
      $('#sidebar-toggle-show').removeClass('d-inline');
      $('#sidebar-toggle-show').removeClass('d-md-none');
   }


   $('#sidebar-toggle-hide').click(function () {
      $('#sidebar').fadeOut(300);
      $('#main-body').animate({ width: "100%" }, 300);
      setTimeout(function () {
         removeAllSidebarToggleClass();
         $('#sidebar-toggle-hide').addClass('d-none');
         $('#sidebar-toggle-show').removeClass('d-none');
      }, 300)
   });



   $('#sidebar-toggle-show').click(function () {
      $('#sidebar').fadeIn(300);
      setTimeout(function () {
         removeAllSidebarToggleClass();
         $('#sidebar-toggle-hide').removeClass('d-none');
         $('#sidebar-toggle-show').addClass('d-none');
      }, 300);
   });

   $('#menu-toggle').click(function () {
      $('#body-header').toggle(300);
   });
   $(window).on('resize', function () {
      var win = $(this); //this = window
      if (win.width() >= 767.980) {
         $('#body-header').show();
      }
      else {
         $('#body-header').hide();
      }

   });


   $('#search-toggle').click(function () {
      $('#search-toggle').removeClass('d-md-inline');
      $('#search-area').addClass('d-md-inline');
      $('#search-input').animate({ width: "12rem" }, 300);
   });

   $('#search-area-hide').click(function () {
      $('#search-input').animate({ width: "0" }, 300);
      setTimeout(function () {
         $('#search-toggle').addClass('d-md-inline');
         $('#search-area').removeClass('d-md-inline');
      }, 300);
   });

   $('#header-notification-toggle').click(function () {
      $('#header-notification').fadeToggle();
   });

   $('#header-comment-toggle').click(function () {
      $('#header-comment').fadeToggle();
   });

   $('#header-profile-toggle').click(function () {
      $('#header-profile').fadeToggle();
   });

   persian={0:'۰',1:'۱',2:'۲',3:'۳',4:'۴',5:'۵',6:'۶',7:'۷',8:'۸',9:'۹'};
	function traverse(el){
		if(el.nodeType==3){
			var list=el.data.match(/[0-9]/g);
			if(list!=null && list.length!=0){
				for(var i=0;i<list.length;i++)
					el.data=el.data.replace(list[i],persian[list[i]]);
			}
		}
		for(var i=0;i<el.childNodes.length;i++){
			traverse(el.childNodes[i]);
		}
	}
    traverse(document.body);
   function subMenuToggle(selector) {
      $(selector).removeClass('sidebar-group-link-active');
      $(selector).children('.sidebar-dropdown-toggle').children('.angle').removeClass('fa-angle-down');
      $(selector).children('.sidebar-dropdown-toggle').children('.angle').addClass('fa-angle-left');
   }

   $('.sidebar-group-link').click(function () {

      if ($(this).hasClass('sidebar-group-link-active')) {
         subMenuToggle(this);
      }
      else {
         subMenuToggle('.sidebar-group-link');
         $(this).addClass('sidebar-group-link-active');
         $(this).children('.sidebar-dropdown-toggle').children('.angle').removeClass('fa-angle-left');
         $(this).children('.sidebar-dropdown-toggle').children('.angle').addClass('fa-angle-down');
      }

   });


});

function readURL(input, previewId) {
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
         $(previewId).attr('src', e.target.result);
         $(previewId).hide();
         $(previewId).fadeIn(650);
      }
      reader.readAsDataURL(input.files[0]);
   }
}

function changeStatus(address, id) {
   $.ajax({
      url: 'http://localhost:8081/php-shop/admin/content/' + address + id,
      success: function (result) {
         var x = jQuery.parseJSON(result)
         if (x.status == "ok") {
            $('#alert').removeClass('d-none');
            $('#alert').html(x.message);
            $('#alert').click(function () {
               $('#alert').addClass('d-none');
            })

         }
      }

   })
}
document.addEventListener("DOMContentLoaded", function () {
   var elements = document.getElementsByTagName("input");
   for (var i = 0; i < elements.length; i++) {
      elements[i].oninvalid = function (e) {
         e.target.setCustomValidity("");
         if (!e.target.validity.valid) {
            e.target.setCustomValidity("پر کردن این فیلد اجباری است");
         }
      };
      elements[i].oninput = function (e) {
         e.target.setCustomValidity("");
      };
   }

   $("#files-logo").change(function () {
      filename = this.files[0].name;
   });
})

function uploaderButton() {
   filename = this.files[0].name;
}
function readURL(input, previewId) {
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
         $(previewId).attr('src', e.target.result);
         $(previewId).hide();
         $(previewId).fadeIn(650);
      }
      reader.readAsDataURL(input.files[0]);
   }
}

function orderSettingToggle(id) {
   $(id).fadeToggle();
}



$('#full-screen').click(function () {
   toggleFullScreen();
});

function toggleFullScreen() {
   if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
      if (document.documentElement.requestFullscreen) {
         document.documentElement.requestFullscreen();
      }
      else if (document.documentElement.mozRequestFullscreen) {
         document.documentElement.mozRequestFullscreen();
      }
      else if (document.documentElement.webkitRequestFullscreen) {
         document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
      }
      $('#screen-compress').removeClass('d-none');
      $('#screen-expand').addClass('d-none');
   }
   else {
      if (document.cancelFullScreen) {
         document.cancelFullScreen();
      }
      else if (document.mozCancelFullScreen) {
         document.mozCancelFullScreen();
      }
      else if (document.webkitCancelFullScreen) {
         document.webkitCancelFullScreen();
      }
      $('#screen-compress').addClass('d-none');
      $('#screen-expand').removeClass('d-none');
   }
}


