<h1>vyd Main -> INDEX</h1>
<code><?=__FILE__?></code>
<div class="container">
    <div id="answer"></div>
    <button class="btn btn-default" id="send">Ajax</button>
    <br>
    <?php new \vendor\widgets\menu\Menu();?>
  <?php if(!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="panel panel-default">
            <div class="panel-heading"><?= $post['title'] ?></div>
            <div class="panel-body">
            <?= $post['article'] ?>
            </div>
        </div>    
    <?php endforeach; ?>
  <?php endif; ?>  
</div>
<script src="/js/test.js"></script>
<script>
$(function(){
    $('#send').click(function(){
        $.ajax({
            url: '/main/test',
            type: 'post',
            data: {'id':2},
            success: function(res){
                //var data = JSON.parse(res);
                //$('#answer').html('<p>Answer: '+ data.answer +'</p>Code: '+ data.code);
                $('#answer').html(res);
                //console.log(res);
            },
            error: function(){
                alert('Error!');
            }
        });
    });
});    
</script>


