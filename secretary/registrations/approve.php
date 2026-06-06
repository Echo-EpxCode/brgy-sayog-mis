<div class="modal fade" id="approveModal<?= $row['user_id'] ?>" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Approve Registration

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="approve_user_id" value="<?= $row['user_id'] ?>">

                    <div class="alert alert-success mb-0">

                        Are you sure you want to approve
                        <strong>
                            <?= htmlspecialchars($row['full_name']) ?>
                        </strong>
                        ?

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" class="btn btn-success">

                        Approve

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
