<div class="modal fade" id="exampleModal-{{ $student->id }}" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <form action="{{ route('getStudentId', $student->id) }}"
                  id="editStudentModal" name="editStudentModal" class="form-horizontal">
                <div class="modal-body">
                    @csrf
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            {!! Form::label('name', 'Student name', []) !!}
                            {!! Form::text('full_name', $student->full_name, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            {!! Form::label('faculty', 'Faculty', []) !!}
                            {!! Form::select('faculty_id', $faculties, isset($student) ? $student->faculty : '', ['class' => 'form-control']) !!}

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            {!! Form::label('email', 'Email', []) !!}
                            {!! Form::text('email', isset($student) ? $student->email : '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            {!! Form::label('birthday', 'Birthday', []) !!}
                            {!! Form::date('birthday', isset($student) ? $student->birthday : '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            {!! Form::label('phone', 'Phone number', []) !!}
                            {!! Form::text('phone', isset($student) ? $student->phone : '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('gender', 'Gender', []) !!}
                        {!! Form::radio('gender', '0', true) !!}
                        <span>Nam</span>
                        {!! Form::radio('gender', '1') !!}
                        <span>Nữ</span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            {!! Form::label('image', 'Image', []) !!}
                            {!! Form::file('image', ['class' => 'form-control-file']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-update"
                                data-modal="exampleModal-{{ $student->id }}">Save
                            changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
