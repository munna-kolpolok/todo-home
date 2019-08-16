function customAlert(title, content, btnText) //title like warning,content=your msg,btnText like ok
{
    $("#lblMessage").html(content);
    $("#alert_dialog").dialog({
        resizable: false,
        title: title,
        modal: true,
        width: '400px',
        height: 'auto',
        bgiframe: false,
        hide: { effect: 'scale', duration: 400 },
        buttons: [
              {
                  text: btnText,
                  click: function () {
                                                              
                      $("#alert_dialog").dialog('close');

                  }
              }
          ]
    });
    $(".ui-dialog").css({
      zIndex: '1060',
      top: '100px'
    });
    $(".ui-dialog .ui-widget-header").css("background","#F2DEDE","color", "#F2DEDE");
    $(".ui-dialog .ui-widget-content").css("color", "#F43F3B");
}

function commonFromDateToDateValidation(from_date,to_date) //from_date id,to_date id 
{
  if(from_date && to_date)
  {

    var from = $('#'+from_date).val().split("/");
    var to=$('#'+to_date).val().split("/");

  
    var date1 = new Date(from[2],from[1],from[0]);
    var date2 = new Date(to[2],to[1],to[0]);
   
    var timeDiff =date2.getTime() - date1.getTime();
    //alert(timeDiff);
    if(timeDiff<0)
    {
      $('#'+from_date).val('');
      $('#'+to_date).val('');
      return false;
    }
    else
    {
      return true;
    }
  }
}

// function dateDiff(from_date,to_date)
// {
//   if(from_date && to_date)
//   {
//     var from = $('#'+from_date).val().split("/");
//     var to=$('#'+to_date).val().split("/");

//     // if(from[1]<9 && to[1]>8)
//     // {
//     //   var date1 = new Date(from[2],from[1],from[0]-1);
//     //   var date2 = new Date(to[2],to[1],to[0]);
//     // }
//     // else
//     // {
//     //   var date1 = new Date(from[2],from[1],from[0]);
//     //   var date2 = new Date(to[2],to[1],to[0]);
//     // }


//     // var date1 = new Date(from[2], from[1],from[0]);
//     // var date2 = new Date(to[2], to[1],to[0]);

//     var date1 = new Date("from[1]/from[0]/from[2]");  //m/d/y
//     var date2 = new Date(to[1]/to[0]/to[2]);

//     var timeDiff =date2.getTime() - date1.getTime();
//     alert(timeDiff);
//     if(timeDiff<0)
//     {
//       return false;
//     }
//     else
//     {
//       var dateDiff=parseInt(timeDiff/(24*3600*1000));
//       return dateDiff;

//     }
//   }
// }


function dateDiff(from_date,to_date)
{
  if(from_date && to_date)
  {
    var from = $('#'+from_date).val().split("/");
    var to=$('#'+to_date).val().split("/");
    
    var date1 = new Date(from[1]+'/'+from[0]+'/'+from[2]); 
    var date2 = new Date(to[1]+'/'+to[0]+'/'+to[2]);

    var timeDiff =date2.getTime() - date1.getTime();

    if(timeDiff<0)
    {
      return false;
    }
    else
    {
      var dateDiff=parseInt(timeDiff/(24*3600*1000));
      return dateDiff;

    }
  }
}