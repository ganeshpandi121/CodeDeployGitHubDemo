<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Job history log</h4></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="height: 200px; overflow: auto">
                        <?php if (!empty($job_history_log)) { ?>
                            <?php echo form_hidden('job_id',$job_id);?>
                            <table class="table table-fixed ">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>User</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody class="text-muted">
                                    <?php foreach ($job_history_log as $item) { ?>
                                        <tr>
                                            <td><?php echo date("F j, Y g:i a", $item->created_date); ?></td>
                                            <td><?php echo $item->user_name; ?></td>
                                            <td><?php echo $item->description; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>