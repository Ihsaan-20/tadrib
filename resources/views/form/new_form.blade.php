@extends('frontend.layouts.app')
@section('app')
    <style>
        .exercise-button {
            display: none;
        }

        .select2 {
            width: 100% !important;
        }
    </style>
    <form action="{{ route('form.store') }}" method="POST" enctype="multipart/form-data" class="px-3">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pro-name" class="form-label">Program Name</label>
                    <input type="text" class="form-control" name="program_name" name="program_name" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="file" class="form-label">Introductory Video</label>
                    <input type="file" class="form-control" name="program_intro_video" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="set-time-number" class="form-label">Text Bio</label>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" name="program_text_bio"
                            id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Comments</label>
                    </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="equipmentNeeded" class="form-label">Equipment Needed:</label>
                    <select multiple="multiple" name="program_equi_needed" class="form-control equipmentNeeded">
                        <option value="Body">Body</option>
                        <option value="Legs">Legs</option>
                        <option value="Back">Back</option>
                        <option value="Shoulder">Shoulder</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="trainingType" class="form-label">Training Type:</label>
                    <select multiple="multiple" name="program_training_type" class="form-control trainingType">
                        <option value="Body">Body</option>
                        <option value="Legs">Legs</option>
                        <option value="Back">Back</option>
                        <option value="Shoulder">Shoulder</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="coachName" class="form-label">Coach Name</label>
                    <select class="form-select" name="coach_id" aria-label="Default select example">
                        <option selected>Coach Name</option>
                        <option value="1">Harry</option>
                        <option value="2">Peter</option>
                        <option value="3">Jason</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="file" class="form-label">Profile Picture</label>
                    <input type="file" class="form-control" name="program_profile" id="file" />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="timeInput" class="form-label">Duration</label>
                    <input type="time" name="program_duration" class="form-control" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="file" class="form-label">Level</label>
                    <select class="form-select" name="program_level" aria-label="Default select example">
                        <option selected>Level</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="file" class="form-label">Price (USD)</label>
                    <input type="tel" class="form-control" id="usdPrice" name="program_price" placeholder="1"
                        oninput="validateNumericInput(this)" />
                </div>
            </div>
    
            <button type="button" class="add-clone btn btn-primary mb-3" onclick="addWorkout()">Add Workout</button>
            <button type="button" class="remove-clone btn btn-primary mb-3" onclick="removeWorkout()">Remove
                Workout</button>
    
            <div class="accordion mb-3" id="accordionExample">
                <div class="accordion-item" id="workout1">
                    {{-- append here --}}
                </div>
    
            </div>
    
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
@endsection
@section('main-js')
<script>
    let workoutCount = -1;
    let setCount = -1;
    let exerciseCount = -1;
    let workoutNumber = 0;

    function addSet(parentWorkout) {
        setCount++;

        const mainSets = parentWorkout.querySelector('.settypeparent');

        const newSetSection = document.createElement('div');
        newSetSection.classList.add('row', 'set-section', 'mb-3', 'bg-light', 'py-3', 'rounded-3');
        newSetSection.id = 'set-' + setCount;

        newSetSection.innerHTML = `
            <h2 id="set-heading">Set</h2>

            <div class="col-md-6 mb-3 settypechk">
                <label for="setType" class="form-label">Set Type</label>
                <select class="form-select set-type" name="workouts[${workoutCount}][sets][${setCount}][set_type]" aria-label="Default select example"
                    onchange="toggleSetType()">
                    <option selected disabled> Select Type</option>
                    <option value="set">Set</option>
                    <option value="super-set">Super Set</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="set-time-number" class="form-label">Number of Time Set</label>
                <input type="number" class="form-control" name="workouts[${workoutCount}][sets][${setCount}][number_of_time_set]" />
            </div>

            <div class="col-md-6 mb-3">
                <label for="intra-set-rest" class="form-label">Intra-Set Rest</label>
                <input type="number" class="form-control" name="workouts[${workoutCount}][sets][${setCount}][intra_set_rest]" />
            </div>

            <div class="col-md-6 mb-3">
                <label for="inter-set-rest" class="form-label">Inter-Set Rest</label>
                <input type="number" class="form-control" name="workouts[${workoutCount}][sets][${setCount}][inter_set_rest]" />
            </div>


            <div class="mb-3 col-md-6">
                <label for="Duration-set" class="form-label">Duration of Set</label>
                <input type="time" name="workouts[${workoutCount}][sets][${setCount}][set_duration]" class="form-control" />
            </div>

            <div class="col-md-12 exercise-button">
                <button type="button" class="add-exercise btn btn-primary mb-3">Add Exercise</button>
                <button type="button" class="remove-exercise btn btn-primary mb-3 ms-2">Remove Exercise</button>
            </div>

            <div class="col-md-12 main-exercises" id="main-exercises">
                <h2 id="exercise-heading">Exercise</h2>

            <div class="col-md-6">
                <label for="set-time-number" class="form-label">Text Bio</label>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here"
                    name="workouts[${workoutCount}][sets][${setCount}][exercises][${exerciseCount}][bio]" ></textarea>
                    <label for="floatingTextarea">Comments</label>
                </div>
            </div>

            <div class="col-md-6">
                <label for="repeat-num" class="form-label">Number of Repeatation</label>
                <input type="number" class="form-control" name="workouts[${workoutCount}][sets][${setCount}][exercises][${exerciseCount}][num_of_repeat]" id="repeat-num" />
            </div>

            <div class="col-md-6">
                <label for="formFile" class="form-label">Default file input example</label>
                <input class="form-control" type="file" name="workouts[${workoutCount}][sets][${setCount}][exercises][${exerciseCount}][input_example]">
            </div>
            </div>
`;

        mainSets.appendChild(newSetSection);
        const addExerciseButton = newSetSection.querySelector('.add-exercise');
        addExerciseButton.addEventListener('click', function () {
            addExercise(newSetSection);
        });
    }

    function addExercise(parentSet) {
        exerciseCount++;

        const mainExercises = parentSet.querySelector('#main-exercises');

        const newExerciseSection = document.createElement('div');
        newExerciseSection.classList.add('exercise-section', 'mb-3', 'bg-light', 'p-3', 'rounded-3');
        newExerciseSection.id = 'exercise-' + exerciseCount;

        newExerciseSection.innerHTML = `
            <h2 id="exercise-heading">Exercise</h2>

            <div class="col-md-6">
                <label for="set-time-number" class="form-label">Text Bio</label>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here"
                    name="workouts[${workoutCount}][sets][${setCount}][exercises][${exerciseCount}][bio]" ></textarea>
                    <label for="floatingTextarea">Comments</label>
                </div>
            </div>

            <div class="col-md-6">
                <label for="repeat-num" class="form-label">Number of Repeatation</label>
                <input type="number" class="form-control" name="workouts[${workoutCount}][sets][${setCount}][exercises][${exerciseCount}][num_of_repeat]" id="repeat-num" />
            </div>

            <div class="col-md-6">
                <label for="formFile" class="form-label">Default file input example</label>
                <input class="form-control" type="file" name="workouts[${workoutCount}][sets][${setCount}][exercises][${exerciseCount}][input_example]">
            </div>
`;

        mainExercises.appendChild(newExerciseSection);
    }

    function addWorkout() {
        workoutCount++;
        ++workoutNumber;

        const accordion = document.getElementById('accordionExample');

        const newAccordionItem = document.createElement('div');
        newAccordionItem.classList.add('accordion-item');
        newAccordionItem.id = 'workout' + workoutCount;

        newAccordionItem.innerHTML = `
            <h2 class="accordion-header" id="heading${workoutCount}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse${workoutCount}" aria-expanded="true" aria-controls="collapse${workoutCount}">
                    Workout ${workoutNumber}
                </button>
            </h2>
            <div id="collapse${workoutCount}" class="accordion-collapse collapse show" aria-labelledby="heading${workoutCount}" data-bs-parent="#accordionExample">
                <div class="accordion-body">

                    <div class="row mb-3 bg-light py-3 rounded-3">
                        <div class="mb-3 col-md-6">
                            <label for="workout" class="form-label">Workout Name</label>
                            <input type="text" class="form-control" name="workouts[${workoutCount}][name]" aria-describedby="emailHelp" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="file" class="form-label">Introdutory Video</label>
                            <input type="file" class="form-control" name="workouts[${workoutCount}][workout_video]" id="file" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="file" class="form-label">Bio</label>
                            <textarea name="workouts[${workoutCount}][workout_bio]" class="form-control"></textarea>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="trainingType" class="form-label">Training Type:</label>
                            <select multiple="multiple" name="workouts[${workoutCount}][workout_training_type]" class="form-control trainingType">
                            <option value="body">Body</option>
                            <option value="legs">Legs</option>
                            <option value="back">Back</option>
                            <option value="shoulder">Shoulder</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="equipmentNeeded" class="form-label">Equipment Needed:</label>
                            <select multiple="multiple" name="workouts[${workoutCount}][workout_equi_needed]" class="form-control equipmentNeeded">
                                <option value="body">Body</option>
                                <option value="legs">Legs</option>
                                <option value="back">Back</option>
                                <option value="shoulder">Shoulder</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="timeInput" class="form-label">Estimated Duration (hours)</label>
                            <input type="time" name="workouts[${workoutCount}][workout_duration]" class="form-control" />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="restDays" class="form-label">Rest (Days)</label>
                            <input type="tel" class="form-control" name="workouts[${workoutCount}][workout_rest_days]" placeholder="1"
                            oninput="validateNumericInput(this)" />
                        </div>


                        <div class="mb-3 col-md-6">
                            <label for="exercises" class="form-label">Number of Exercises</label>
                            <input type="number" class="form-control" name="workouts[${workoutCount}][num_of_exercises]" />
                        </div>

                    </div>

                        <div>
                            <div class="col-md-12">
                                <button type="button" class="add-set btn btn-primary mb-3">Add Set</button>
                                <button type="button" class="remove-set btn btn-primary mb-3">Remove Set</button>
                            </div>


                            <div class="settypeparent" id="main-sets">
                                <!-- Initial Set Section -->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
`;

        accordion.appendChild(newAccordionItem);

        // Attach the event listener to the initial "Add Set" button
        const addSetButton = newAccordionItem.querySelector('.add-set');
        addSetButton.addEventListener('click', function () {
            addSet(newAccordionItem);
        });

        // Attach the event listener to the initial "Add Exercise" button
        const addExerciseButton = newAccordionItem.querySelector('.add-exercise');
        addExerciseButton.addEventListener('click', function () {
            addExercise(newAccordionItem);
        });
    }

    // Example event listener for the initial "Add Set" button
    const addSetButton = document.querySelector('.add-set');
    addSetButton.addEventListener('click', function () {
        addSet(document.getElementById('workout1')); // Example: Adding set to the first workout initially
    });

    // Example event listener for the initial "Add Workout" button
    const addWorkoutButton = document.querySelector('.add-workout');
    addWorkoutButton.addEventListener('click', addWorkout);
</script>
<script>
    $(document).ready(function () {
        // Use 'on' to attach the event handler dynamically
        $(document).on('change', '.set-type', function () {
            // Get the selected value for the specific dropdown
            var selectedValue = $(this).val();



            // Alert the selected value (for debugging)
            // alert(selectedValue);

            // Show the selected set type for the specific dropdown
            if (selectedValue === 'set') {
                $(this).parent('.settypechk').siblings('.exercise-button').css("display", "none");

            } else if (selectedValue === 'super-set') {
                $(this).parent('.settypechk').siblings('.exercise-button').css("display", "flex");
            }

        });
    });
</script>
@endsection
