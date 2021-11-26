
        function getChat(){
          $.ajax({
              url : base_url+'/api/getChat',
              type : 'GET',
              dataType:'json',
              success : function(data) {     
              },
              error : function(request,error)
              {
                  
              }
          });
          
        } 