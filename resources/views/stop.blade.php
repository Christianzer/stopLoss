@extends('layout')

@section('contenu')
    <!-- Page Heading -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-uppercase">APPLICATION STOP LOSS</li>
            <li class="breadcrumb-item text-primary text-uppercase" aria-current="page">GÉRER LES NIVEAUX DE STOP LOSS</li>
        </ol>
    </nav>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{$message}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{$message}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <form action="{{isset($position) ? route("stop.update",$position->id_stop_loss) : route("stop.create")}}" method="post">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-uppercase text-primary">Informations générales stop loss</h6>
            </div>
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold text-uppercase">Actif financier</label>
                        <select class="form-control font-weight-bold text-uppercase" name="actif_financier_id">
                            @foreach($list_actifs as $key => $item)
                                @if(isset($position))
                                    @if($key == $position->actif_financier_id)
                                        <option value="{{$key}}" selected>{{ $item }}</option>
                                    @else
                                        <option value="{{$key}}">{{ $item }}</option>
                                    @endif
                                @else
                                    <option value="{{$key}}">{{ $item }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold text-uppercase" for="symbole">Niveau Stop Loss</label>
                        <input type="number" step="any" class="form-control font-weight-bold text-uppercase" id="niveau_stop_loss" name="niveau_stop_loss"  value="{{isset($position) ? $position->niveau_stop_loss : ''}}" required>
                    </div>
                </div>







                <div align="right">
                    <a href="{{route('stop.index')}}" class="btn btn-danger text-uppercase">Retour</a>
                    <button  class="btn btn-warning text-uppercase" type="reset">Annuler</button>
                    <button id="demande_enregistrer" class="btn btn-primary text-uppercase"  type="submit">{{isset($position) ? 'Modifier' : 'Enregistrer'}}</button>
                </div>
                <br>
            </div>
        </div>


    </form>

    <form method="post" action="{{route('stop.delete')}}">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-uppercase text-primary">Listes des stop loss</h5>
            </div>
            <div class="card-body">

                <table class="table table-striped table-bordered w-100" style="font-size: 16px">
                    <thead>
                    <tr class="bg-indigo text-black-50 w-100 text-uppercase font-weight-bold">
                        <th></th>
                        <th>#</th>
                        <th>Actifs financier</th>
                        <th>Niveau Stop Loss</th>
                        <th>Niveau declenchement</th>
                        <th>Etat</th>

                    </tr>



                    </thead>


                    <tbody class="text-black text-uppercase font-weight-bold">
                    @foreach($stops as $item)
                        <tr>
                            <td align="center"><input type="checkbox" id="cocher[]" required name="cocher[]"
                                                      value="{{$item->id_stop_loss}}"></td>
                            <td><a href="{{route('stop.edit',$item->id_stop_loss)}}">{{$item->id_stop_loss}}</a></td>
                            <td>{{$item->nom}}</td>
                            <td class="text-right">{{number_format($item->niveau_stop_loss,'2','.',' ')}}</td>
                            <td>{{$item->etat}}</td>
                        </tr>


                    @endforeach

                    </tbody>
                </table>

                <div align="right"><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#DeleteEvaluationModal"
                                      style="margin: 20px;"><i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i> Supprimer la sélection</a>
                </div>

            </div>



        </div>


        <div class="modal fade" id="DeleteEvaluationModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer la sélection
                            ?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Cliquez sur le bouton "Supprimer" ci-dessous si vous voulez supprimer les
                        éléments sélectionnés.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                        <!--<a class="btn btn-primary" href="index.php?page=aj_etab&amp;act=save">Enregistrer</a>-->
                        <button type="submit" class="btn btn-danger" name="supprimer"><i
                                class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection
