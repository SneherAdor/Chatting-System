sessionStorage.removeItem('user_id');
//Generete random number using date and random number
function randomNumber(){
  function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

var seconds = new Date().getTime();
var seconds = Math.floor(seconds);
return randomnumber = seconds+"_"+getRandomInt(5000,500000);
}

  // $(".user_id").click(function() {  
  //   $(".chat-logs").html('');
  // })

$(function() {

   var user_id = '';

    $(".user_id").on("click", "a", function(e) {
      e.preventDefault();
      clearInterval(messageFetch);
      $(".chat-box").hide('scale');  
      $("#chat-circle").toggle('scale');
      $(".chat-box").show('scale');
      user_id = $(this).text();
      $(".chat-logs").html('');
      var messageFetch = setInterval(function() 
        {
          $.get("http://localhost/qblogin/public/chat/"+user_id, 
          function(data, status){
            $(".chat-logs").html(data);
            $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);
        
          }
          );
        }, 500);
  });

  var INDEX = 0; 
  $("#chat-submit").click(function(e) {
    e.preventDefault();
    var msg = $("#chat-input").val();
    var type = $("#chat-type").val();
    var agent_id = $("#agent_id").val();
    $.ajax({

        method: "POST",
        url:"http://localhost/qblogin/public/chat-send",
        dataType: "json",
        data: {
            'user_id': user_id,
            'agent_id': agent_id,
            'type': type,
            'message': msg
        },
        success:
        function(){
          $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);
        }
    }) 
    if(msg.trim() == ''){
      return false;
    }
    if (type == 'agent') {
      generate_message(msg, 'agent');
    }
    if (type == 'user') {
      generate_message(msg, 'user');
    }
    
  })


  
  function generate_message(msg, type) {
    INDEX++;

    var str = '<div id="cm-msg-'+INDEX+'" class="chat-msg '+type+'"><span class="msg-avatar"><img src="https://image.crisp.chat/avatar/operator/7a702e9c-85b7-4ded-aa9a-ec2edda6f43b/240/?1575851691353"></span><div class="cm-msg-text">'+msg+'</div></div>';

    $(".chat-logs").append(str);
    $("#cm-msg-"+INDEX).hide().fadeIn(300);
    $("#chat-input").val('');    
    $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);    
  }

  
  $(document).delegate(".chat-btn", "click", function() {
    var value = $(this).attr("chat-value");
    var name = $(this).html();
    $("#chat-input").attr("disabled", false);
    generate_message(name, 'agent');
  })

  
  $("#chat-circle").click(function() {    
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  }) 

  // $(".user_id").click(function() {  
  //   $(".chat-box").hide('scale');  
  //   $("#chat-circle").toggle('scale');
  //   $(".chat-box").show('scale');
  // })

  $(".chat-box-toggle").click(function() {
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  })
  
})

