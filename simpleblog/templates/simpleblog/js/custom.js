
(function($)
{
	$(document).ready(function(){
		// $('.btn-primary').removeClass('btn-primary')
		// $('.btn').addClass('sb-button')

    $("#login-form span.hasTooltip").removeAttr("data-original-title")
    $("#login-form span.hasTooltip").removeClass("hasTooltip")

		$(".hasTooltip").removeAttr("data-original-title")
		$(".hasTooltip").removeClass("hasTooltip")

    $('[data-toggle="tooltip"]').tooltip({"placement":"top","animation":false})//.tooltip('show')

    $(".alert").click(function() {
      $(this).fadeOut()
    })

    // $(":text").first().focus()
    // $(":text").unbind("blur")
	})
})(jQuery);

function sortHeader(th){
  var link=th.firstElementChild
  link.click()
}

function openArticle(url){
	location=url
}

function changeLayout(select){
  var value=select.value
  switch(value){
    case 'blog':
      location='index.php?option=com_content&view=category&layout=simpleblog:myarticlesblog&id=8&Itemid=158'
      break
    case 'list':
      location='index.php?option=com_content&view=category&layout=simpleblog:myarticleslist&id=8&Itemid=157'
      break
  }
}

function selectCheckbox(event,cell){
  if(event.target==cell){
    var checkbox=cell.firstElementChild
    checkbox.click()
  }
}

function performToolbarAction(event,action){
  var checkboxes=document.getElementsByName("cid[]")
  var selected=false
  for(var i in checkboxes){
    if(checkboxes[i].checked){
      selected=true
      break;
    }
  }
  if(!selected){
    alert("Select an article")
    event.preventDefault();
  }
  else{
    Joomla.submitbutton(action)
  }
}
