<div class="modal fade" id="releaseModal<?= $row['id'] ?>" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="process_release.php" method="POST">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Release Certificate

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="request_id" value="<?= $row['id'] ?>">

                    <div class="alert alert-primary">

                        Mark this request as released?

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" class="btn btn-primary">

                        Release

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
