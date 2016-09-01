        <h6> Lampiran : </h6>
        <div class="row">
              <div class="col-xs-12 tempatlampiran">
                    <?php foreach($resp->lampiran as $lamp){ ?>
                    <div class="col-xs-1 filelampiran">
                        <?php switch($lamp->fileext){
                                case "pdf":
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-pdf-o"></i> </a>';
                                break;

                                case "docx":
                                case "doc":
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-word-o"></i> </a>';
                                break;

                                case "7zip":
                                case "rar":
                                case "zip":
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-archive-o"></i> </a>';
                                break;

                                case "mp3":
                                case "wav":
                                case "m3a":
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-film"></i> </a>';
                                break;

                                case "mp4":
                                case "3gp":
                                case "mpeg":
                                case "wmv":
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-audio-o"></i> </a>';
                                break;

                                case "csv":
                                case "xls":
                                case "xlsx":
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-excel-o"></i> </a>';
                                break;

                                case "ppt":
                                case "pptx":
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-powerpoint-o"></i> </a>';
                                break;

                                case "png":
                                case "jpg":
                                case "psd":
                                case "svg":
                                case "gif":
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-image-o"></i> </a>';
                                break;

                                case "txt":
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-text-o"></i> </a>';
                                break;

                                default:
                                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-o"></i> </a>';
                                break;

                        } ?>
                </div>
                <?php }
                echo "</div></div>";
                ?>