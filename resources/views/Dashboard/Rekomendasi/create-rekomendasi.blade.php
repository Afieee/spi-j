<div class="form-group">
    <!-- Modal -->
    <div class="modal fade text-left" id="tambahRekomendasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17"><strong>Tambah Rekomendasi</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset class="form-group floating-label-form-group">
                        <label for="nomorLHA">Nomor LHA</label>
                        <div class="position-relative has-icon-left">
                            <input type="text" id="nomorLHA" class="form-control" placeholder="87291289128"
                                name="nomorLHA" disabled>
                            <div class="form-control-position">
                                <i class="fa fa-briefcase"></i>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="temuan">Temuan</label>
                        <div class="position-relative has-icon-left">
                            <select id="optionSelect" class="form-control">
                                <option selected>-- Pilih Temuan --</option>
                                <option value="1">Tata Kelola Administratif SPI</option>
                                <option value="2">Administrasi Frontoffice</option>
                                <option value="3">Peningkatan Website SPI</option>
                            </select>
                            <div class="form-control-position">
                                <i class="fa fa-exclamation-circle"></i>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="rekomendasi">Rekomendasi</label>
                        <div class="position-relative has-icon-left">
                            <input type="text" id="rekomendasi" class="form-control" placeholder="Rekomendasi"
                                name="rekomendasi">
                            <div class="form-control-position">
                                <i class="fa fa-file-o"></i>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="status">Status</label>
                        <div class="position-relative has-icon-left">
                            <select id="optionSelect" class="form-control">
                                <option selected>-- Pilih Status --</option>
                                <option value="open">Open</option>
                                <option value="onprogress">On Progress</option>
                                <option value="closed">Closed</option>
                            </select>
                            <div class="form-control-position">
                                <i class="fa fa-info-circle"></i>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger mr-1" data-dismiss="modal" value="close">
                        <i class="ft-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-outline-success">
                        <i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
