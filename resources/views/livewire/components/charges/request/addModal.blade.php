<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar solicitud de cobro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label>Empresa</label>
                    <select class="form-control @error('charge.company') is-invalid @enderror" wire:model="charge.company">
                        <option value="">-- Seleccione --</option>
                        @foreach ($companies as $c)
                            <option>{{$c}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-6">
                    <label>Tipo de cobro</label>
                    <select class="form-control @error('charge.change_type') is-invalid @enderror" wire:model.debounce="charge.charge_type">
                        <option value="">-- Seleccione --</option>
                        <option>Ordinario</option>
                        <option>Extraordinario</option>
                    </select>
                </div>
                
            </div>
            <div class="row">
                
                <div class="form-group col-sm-6">
                    <label>Periodicidad</label>
                    <select class="form-control @error('charge.periodicity') is-invalid @enderror" wire:model.debounce="charge.periodicity">
                        <option value="">-- Seleccione --</option>
                        <option>Una vez</option>
                        <option>Recurrente</option>
                    </select>
                </div>
                @if(isset($charge['periodicity']) && $charge['periodicity']=="Una vez")
                <div class="form-group col-sm-6">
                    <label for="exampleInputEmail1">Fecha</label>
                    <input type="date" class="form-control @error('charge.date') is-invalid @enderror" wire:model.debounce="charge.date" />
                </div>
                @endif
                @if(isset($charge['periodicity']) && $charge['periodicity']=="Recurrente")
                <div class="form-group col-sm-6">
                    <label>Día</label>
                    <select class="form-control @error('charge.day') is-invalid @enderror" wire:model.debounce="charge.day">
                        <option value="">-- Seleccione --</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                        <option>21</option>
                        <option>22</option>
                        <option>23</option>
                        <option>24</option>
                        <option>25</option>
                        <option>26</option>
                        <option>27</option>
                        <option>28</option>
                        <option>29</option>
                        <option>30</option>
                        <option>31</option>
                    </select>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label>Categorías</label>
                    <select class="form-control @error('charge.category') is-invalid @enderror" wire:model.debounce="charge.category">
                        <option value="">-- Seleccione --</option>
                        @foreach ($categories as $c)
                            <option>{{$c}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-6">
                    <label for="exampleInputEmail1">Monto</label>
                    <div style="display: flex">
                        <select class="form-control mb-3" style="width:110px" wire:model.debounce="charge.currency">
                            <option selected="" value="₡">₡ (Colón)</option>
                            <option value="$">$ (Dolar)</option>
                          </select>
                          <input type="number" class="form-control @error('charge.amount') is-invalid @enderror" placeholder="0.00" step="any" wire:model.debounce="charge.amount">
                    </div>
                  
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12">
                    <label>Observación</label>
                    <textarea class="form-control" rows="3" placeholder="Observación" wire:model.debounce="charge.observation"></textarea>
                </div>
            </div>
            @can("manage ssc charge status")
            <div class="row">
                <div class="form-group">
                    <label>Status de solicitud</label>
                    <div class="custom-control custom-switch custom-switch-off-warning custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" wire:model="approved">
                    <label class="custom-control-label" for="customSwitch1">{{$approved ? 'Aprobada':'Pendiente'}}</label>
                    </div>
                </div>
            </div>
            @endcan
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" wire:click="save">Crear</button>
        </div>
      </div>
    </div>
  </div>
  @push("scripts")
    <script>
        Livewire.on("closeModal",()=>{
            $("#addModal .close").click();
        })
    </script>
  @endpush