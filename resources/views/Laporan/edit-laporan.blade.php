<div class="form-group">
    <!-- Modal -->
    <div class="modal fade text-left" id="editLaporan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17"><strong>Edit Laporan SPI</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset class="form-group floating-label-form-group">
                        <label for="nomorLaporan">Nomor Laporan</label>
                        <div class="position-relative has-icon-left">
                            <input type="text" id="nomorLaporan" class="form-control" placeholder="Nomor Laporan"
                                name="nomorLaporan">
                            <div class="form-control-position">
                                <i class="fa fa-briefcase"></i>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="tanggal">Tanggal Laporan</label>
                        <div class="position-relative has-icon-left">
                            <input type="date" id="tanggal" class="form-control" name="tanggal">
                            <div class="form-control-position">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="judul">Judul</label>
                        <div class="position-relative has-icon-left">
                            <input type="text" id="judul" class="form-control" placeholder="Judul"
                                name="judul">
                            <div class="form-control-position">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="divisi">Divisi/Unit</label>
                        <div class="position-relative has-icon-left">
                            <input type="text" id="divisi" class="form-control" placeholder="Divisi/Unit"
                                name="divisi">
                            <div class="form-control-position">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="keterangan">Keterangan</label>
                        <div class="position-relative has-icon-left">
                            <textarea id="keterangan" rows="5" class="form-control" name="keterangan"
                                placeholder="Keterangan"></textarea>
                            <div class="form-control-position">
                                <i class="fa fa-info"></i>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="attacment">Attacment</label>
                        <div class="position-relative has-icon-left">
                            <input type="file" name="attacment" id="attacment" class="form-control">
                            <div class="form-control-position">
                                <i class="fa fa-file-pdf-o"></i>
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
