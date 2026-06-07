<div class="modal fade" id="viewModal<?= $row['id'] ?>" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header bg-success text-white">

                <h5 class="modal-title">
                    Request Details
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="text-muted">Document</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['document_name']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Certificate No.</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['certificate_no'] ?? '-') ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="text-muted">Purpose</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['purpose']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Status</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['status']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Requested At</label>
                        <div class="fw-bold">
                            <?= date('M d, Y h:i A', strtotime($row['requested_at'])) ?>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="col-12">
                        <h6 class="fw-bold">
                            Resident Information
                        </h6>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Full Name</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars(
                                trim(
                                    ($row['first_name'] ?? '') . ' ' .
                                    ($row['middle_name'] ?? '') . ' ' .
                                    ($row['last_name'] ?? '') . ' ' .
                                    ($row['suffix'] ?? '')
                                )
                            ) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Household No.</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['household_no'] ?? '') ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Contact No.</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['contact_no'] ?? '') ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="text-muted">Address</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['address'] ?? '') ?>
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <?php if (
                    $row['status'] === 'Released' &&
                    !empty($row['file_path'])
                ): ?>

                    <a href="download.php?id=<?= $row['id'] ?>" class="btn btn-success">

                        <i class="bi bi-download"></i>
                        Download PDF

                    </a>

                <?php endif; ?>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>
