<!-- VIEW MODAL -->

<div class="modal fade" id="viewModal<?= $row['id'] ?>" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Request Details

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">
                            Resident
                        </label>

                        <p>
                            <?= htmlspecialchars($row['resident_name']) ?>
                        </p>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">
                            Document Type
                        </label>

                        <p>
                            <?= htmlspecialchars($row['document_name']) ?>
                        </p>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">
                            Status
                        </label>

                        <p>
                            <?= htmlspecialchars($row['status']) ?>
                        </p>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">
                            Requested At
                        </label>

                        <p>
                            <?= date(
                                'M d, Y h:i A',
                                strtotime($row['requested_at'])
                            ) ?>
                        </p>

                    </div>

                    <div class="col-12">

                        <label class="fw-bold">
                            Purpose
                        </label>

                        <div class="border rounded p-3 bg-light">

                            <?= nl2br(
                                htmlspecialchars($row['purpose'])
                            ) ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
