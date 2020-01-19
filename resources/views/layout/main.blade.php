<!DOCTYPE html>
<html>
  <head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>@yield('title')</title>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>

  <body>
    @yield('content')
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonyous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
      function getData() {
        $('.todo').html('')
        $('.doing').html('')
        $('.done').html('')
        $.ajax({
          url: '/getData',
          method: 'get',
          dataType: 'json',
          success: function(todolist) {
            todolist.forEach(doc => {
              switch (doc.status) {
                case 0:
                  $('.todo').append(`
                  <li class="collection-item"><div>`+doc.title+`<a class="secondary-content modal-trigger detail-button waves-effect waves-light badge " onclick="return openUpModal('${doc.id}', '${doc.title}', '${doc.description}', '${doc.created_at}', '${doc.status}');">Detail</a></div></li>
                  `)
                break;

                case 1:
                  $('.doing').append(`
                    <li class="collection-item"><div>`+doc.title+`<a class="secondary-content modal-trigger detail-button detail-modal waves-effect waves-light badge " onclick="return openUpModal('${doc.id}', '${doc.title}', '${doc.description}', '${doc.created_at}', '${doc.status}');">Detail</a></div></li>
                  `)
                break;

                case 2:
                  $('.done').append(`
                    <li class="collection-item"><div>`+doc.title+`<a class=" secondary-content modal-trigger detail-button detail-modal waves-effect waves-light badge " onclick="return openUpModal('${doc.id}', '${doc.title}', '${doc.description}', '${doc.created_at}', '${doc.status}');">Detail</a></div></li>
                  `)
                break;

              }
            })
          }
        })
      }

      function openUpModal(id, title, description, createdAt, status) {
        $('#detail').modal();
        $('#titleInModal').text(title)
        $('#descInModal').text(description)
        $('#createdAt').text(createdAt)
        switch (parseInt(status)) {
          case 0:
            elementString = `<button class="waves-effect waves-light btn-small red darken-2 align-wrapper center-align" onclick="return deleteTask('${id}')">Delete</button>
            <button class="waves-effect waves-light btn-small blue darken-2 align-wrapper right-align" onclick="return changeTaskStatus('${id}', '${status}', 'doing')">Doing</button>`
          break;
          case 1:
            elementString = `<button class="waves-effect waves-light btn-small orange darken-2 align-wrapper right-align" onclick="return changeTaskStatus('${id}', '${status}', 'todo')">To do</button>
            <button class="waves-effect waves-light btn-small red darken-2 align-wrapper center-align" onclick="return deleteTask('${id}')">Delete</button>
            <button class="waves-effect waves-light btn-small green darken-2 align-wrapper right-align" onclick="return changeTaskStatus('${id}', '${status}', 'done')">Done</button>`
          break;
          case 2: 
            elementString = `<button class="waves-effect waves-light btn-small blue darken-2 align-wrapper right-align" onclick="return changeTaskStatus('${id}', '${status}', 'done to doing')">Doing</button>
            <button class="waves-effect waves-light btn-small red darken-2 align-wrapper center-align" onclick="return deleteTask  ('${id}')">Delete</button>`
          break;
        }
        $('.buttonOnModalDetail').html(elementString)
        let detailModal = M.Modal.getInstance($('#detail'))
        detailModal.open()
      }

      $(document).ready(function(){
        getData()
      });

      $('.add-new').modal({
        onOpenStart: function() {
          $('.errorTitleField').text('')
          $('.errorDescField').text('')
          $('.title').val('')
          $('.description').val('')
        }
      });

      $('.submit-button').on('click', function() {
        $.ajax({
          url: '/',
          method: 'post',
          dataType: 'json',
          data: {
            title: $('.title').val(),
            description: $('.description').val(),
            _token: $('input[name="_token"]').val()
          },
          success: function(response) {
            if (response.status) {
              let addNewModal = M.Modal.getInstance($('.add-new'));
              M.toast({html: response.msg})
              addNewModal.close()
              getData()
            } else {
              $('.errorTitleField').text(response.msg[0])
              $('.errorDescField').text(response.msg[1])
            }
          }
        })
      })
      function changeTaskStatus(id, status, type) {
        $.ajax({
          url: `/changeTaskStatus/${id}/${status}/${type}`,
          method: 'get',
          dataType:'json',
          success: function(response) {
            let detailModal = M.Modal.getInstance($('#detail'))
            detailModal.close()
            getData()
          }
        })
      }

      function deleteTask(id) {
        $.ajax({
          url: `/deleteTask/${id}`,
          method: 'get',
          success: function() {
            let detailModal = M.Modal.getInstance($('#detail'))
            detailModal.close()
            getData()
          }
        })
      }

    </script>
  </body>
</html>
        