<div class="panel panel-primary">
    
    <div class="panel-heading text-center"><h1>Diary</h1></div>


<div class="panel-body">
    
    
    <div class="col-md-8 table table-striped table-bordered">
    
    <table id="guild_table" class="display" cellspacing="0" width="100%">
        <caption><h3>Last 24 hours events</h3></caption>
        <thead>
            <tr>
                <th>Event</th>
                <th>Date</th>
                <th>Position X</th>
                <th>Position Y</th>
            </tr>
        </thead>
    <tbody>
            <?php foreach ($raw as $item) :?>
                <tr>
                    <td><?php echo $item['Event']['name']; ?></td>
                     <td><?php echo $item['Event']['date']; ?></td>
                     <td><?php echo $item['Event']['coordinate_x']; ?></td>
                     <td><?php echo $item['Event']['coordinate_y']; ?></td>
                </tr>

            <?php endforeach;?>
    </tbody>
    </table>
</div>
    
    
</div>
</div>