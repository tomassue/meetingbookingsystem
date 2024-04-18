<div>
    <div class="card mt-5 ">
        <div class="card-body">
            <h5 class="text-start card-title">DILI NA NI SIYA MANUAL.</h5>

            <form wire:submit="save">
                <div class="row mt-3 p-3">
                    <div class="col-md-3">
                        <label for="start_date_time" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control" wire:model="start_date_time">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date_time" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control" wire:model="end_date_time">
                    </div>
                    <div class="col-md-6">
                        <label for="type_of_attendees" class="form-label">Type of Attendees</label>
                        <select id="type_of_attendees" class="form-select" wire:model="type_of_attendees">
                            <option selected>Choose...</option>
                            <option value="Department Heads">Department Heads</option>
                            <option value="Department Shoulders">Department Shoulders</option>
                            <option value="Department Knees">Department Knees</option>
                            <option value="Department Toes">Department Toes</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3 p-3">
                    <div class="col-12">

                        <label for="attendees" class="form-label">Attendees</label>
                        <div id="formfield">
                            @foreach($attendees as $index => $attendee)
                            <div class="col-12 row">
                                <div class="col-6" wire:ignore.self>
                                    <!-- <input type="text" class="form-control mb-3" wire:model="attendees.{{ $index }}.users_id" placeholder="Input Name"> -->
                                    <select class="form-control js-example-basic-single" name="state" wire:model="attendees.{{ $index }}.users_id">
                                        @foreach($users as $item)
                                        <option value="{{ $item->id }}" {{ $attendees[$index]['users_id'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->full_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control mb-3" placeholder="DANI IBUTANG ANG DEPARTMENT" readonly>
                                </div>
                                <div class="col-1">
                                    <a role="button" class="btn btn-danger" wire:click="removeAttendee({{ $index }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.92 22c5.5 0 10-4.5 10-10s-4.5-10-10-10-10 4.5-10 10 4.5 10 10 10ZM7.92 12h8" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <a class="btn btn-primary add" href="#" role="button" wire:click="addAttendee">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2 2 6.5 2 12s4.5 10 10 10ZM8 12h8M12 16V8" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class=" row p-3">
                    <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Subject</label>
                        <input type="text" class="form-control" wire:model="subject">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Attach File</label>
                        <input type="file" class="form-control" wire:model="file">
                    </div>
                </div>

                <div class="row p-3">
                    <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Meeting Discription</label>
                        <input type="text" class="form-control" wire:model="meeting_description">
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center mb-2">
                    <button class="btn btn-primary col-md-3" type="submit">Book Meeting</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        // var formfield = document.getElementById('formfield');

        // function add() {
        //     // Create a new div to contain both the input field and the remove button
        //     var newFieldContainer = document.createElement('div');
        //     newFieldContainer.setAttribute('class', 'col-12 mb-1 row'); // Added row class to ensure button alignment
        //     newFieldContainer.setAttribute('style', 'padding-right: 0px;');

        //     // Create the div to contain the input field
        //     var newDiv = document.createElement('div');
        //     newDiv.setAttribute('class', 'row col-11');

        //     var newInnerDiv = document.createElement('div');
        //     newInnerDiv.setAttribute('class', 'col-7');

        //     var newInnerDiv2 = document.createElement('div');
        //     newInnerDiv2.setAttribute('class', 'col-5')

        //     // Create the first input field
        //     var newField = document.createElement('input');
        //     newField.setAttribute('type', 'text');
        //     newField.setAttribute('class', 'form-control mb-3'); // Adding Bootstrap class for styling
        //     newField.setAttribute('wire:model', 'attendees');
        //     newField.setAttribute('placeholder', 'Input Name');

        //     // Create the second input field
        //     var newField2 = document.createElement('input');
        //     newField2.setAttribute('type', 'text');
        //     newField2.setAttribute('class', 'form-control mb-3'); // Adding Bootstrap class for styling
        //     newField2.setAttribute('placeholder', 'DEPARTMENT IBUTANG DANI');
        //     newField2.setAttribute('readonly');

        //     // Append the input fields to the div
        //     newInnerDiv.appendChild(newField);
        //     newInnerDiv2.appendChild(newField2);

        //     // Append the innerDiv fields to the newDiv
        //     newDiv.appendChild(newInnerDiv);
        //     newDiv.appendChild(newInnerDiv2);

        //     // Append the div to the container
        //     newFieldContainer.appendChild(newDiv);

        //     // Create the div to contain the remove button
        //     var newDiv2 = document.createElement('div');
        //     newDiv2.setAttribute('class', 'col-1');

        //     // Create the remove button
        //     var newButton = document.createElement('a');
        //     newButton.setAttribute('role', 'button');
        //     newButton.setAttribute('class', 'btn btn-danger');
        //     newButton.setAttribute('style', 'background-color: red !important; border-color: red !important');
        //     newButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="25" viewBox="0 0 24 24" fill="none"><path d="M21 5.98c-3.33-.33-6.68-.5-10.02-.5-1.98 0-3.96.1-5.94.3L3 5.98M8.5 4.97l.22-1.31C8.88 2.71 9 2 10.69 2h2.62c1.69 0 1.82.75 1.97 1.67l.22 1.3M18.85 9.14l-.65 10.07C18.09 20.78 18 22 15.21 22H8.79C6 22 5.91 20.78 5.8 19.21L5.15 9.14M10.33 16.5h3.33M9.5 12.5h5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
        //     newButton.setAttribute('onclick', 'removeField(this.parentNode.parentNode)'); // Pass the grandparent node to the remove function

        //     // Append the remove button to the div
        //     newDiv2.appendChild(newButton);

        //     // Append the div to the container
        //     newFieldContainer.appendChild(newDiv2);

        //     // Append the container to the formfield
        //     formfield.appendChild(newFieldContainer);
        // }

        // function removeField(container) {
        //     // Remove the container which contains both the input field and the remove button
        //     formfield.removeChild(container);
        // }

        // In your Javascript(external.js resource or < script > tag)
        // $(document).ready(function() {
        //     $('.js-example-basic-single').select2();
        // });
    </script>
</div>