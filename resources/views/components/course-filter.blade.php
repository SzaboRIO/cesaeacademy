<form action="{{ request()->route()->getName() == 'courses.area' ? route('courses.area', ['area' => request('area')]) : route('courses.index') }}" method="GET" id="courseFilterForm">
    @if(request()->has('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
    @endif
    
    @if(request()->route()->getName() == 'courses.area')
        <input type="hidden" name="area" value="{{ request('area') }}">
    @endif
    
    <div class="accordion" id="courseFilterAccordion">
        <div class="accordion-item m-0 rounded-0 no-hover">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Categorias
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
              <div class="accordion-body">
                  <div id="filter-category">
                      @if(request()->route()->getName() == 'courses.area')
                          <h6 class="fw-bold">{{ request('area') }}</h5>
                      @else
                          <div class="form-check">
                              <input class="form-check-input filter-all" 
                                  type="checkbox" 
                                  name="category_all" 
                                  value="1" 
                                  id="categoryAll"
                                  {{ !request()->has('category') ? 'checked' : '' }}
                                  onchange="this.form.submit()">
                              <label class="form-check-label fw-bold" for="categoryAll">
                                  Todos
                              </label>
                          </div>
                          <hr class="my-2">
                          
                          @foreach($categories as $category)
                              <div class="form-check">
                                  <input class="form-check-input filter-checkbox category-checkbox" 
                                      type="checkbox" 
                                      name="category[]" 
                                      value="{{ $category->id }}" 
                                      id="category{{ $category->id }}"
                                      {{ in_array($category->id, request('category', [])) ? 'checked' : '' }}
                                      onchange="this.form.submit()">
                                  <label class="form-check-label" for="category{{ $category->id }}">
                                      {{ $category->area }}
                                  </label>
                              </div>
                          @endforeach
                      @endif
                  </div>
              </div>
          </div>
        </div>
        <div class="accordion-item m-0 rounded-0 no-hover">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Nível
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div id="filter-level">
                        @php
                            $levels = ['Iniciante', 'Intermédio', 'Avançado'];
                            $selectedLevels = request('level', []);
                        @endphp
                        
                        <div class="form-check">
                            <input class="form-check-input filter-all" 
                                type="checkbox" 
                                name="level_all" 
                                value="1" 
                                id="levelAll"
                                {{ !request()->has('level') ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <label class="form-check-label fw-bold" for="levelAll">
                                Todos
                            </label>
                        </div>
                        <hr class="my-2">
                        
                        @foreach($levels as $level)
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox level-checkbox" 
                                    type="checkbox" 
                                    name="level[]" 
                                    value="{{ $level }}" 
                                    id="level{{ Str::slug($level) }}"
                                    {{ in_array($level, $selectedLevels) ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <label class="form-check-label" for="level{{ Str::slug($level) }}">
                                    {{ $level }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>