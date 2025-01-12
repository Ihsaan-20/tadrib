@extends('frontend.layouts.app')
@section('app')
<div class="d-flex justify-content-center">
    <div class="col-lg-12">
      
      <form action="" method="POST" enctype="multipart/form-data">
        @csrf



        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="pro-name" class="form-label">Program Name</label>
            <input type="text" class="form-control" name="id" value="{{ $data->id }}" id="pro-name" />
            <input type="text" class="form-control" name="program_name[]" value="{{ $name}}" id="pro-name" />
          </div>
          <div class="col-md-6 mb-3">
            <label for="file" class="form-label">Introdutory Video</label>
            <input type="file" class="form-control" name="program_intro_video" id="file" />
          </div>
          <div class="col-md-6 mb-3">
            <label for="set-time-number" class="form-label">Text Bio</label>
            <div class="form-floating">
              <textarea class="form-control" placeholder="Leave a comment here" name="program_text_bio[]" id="floatingTextarea"></textarea>
              <label for="floatingTextarea">Comments</label>
            </div>
          </div>
          <div class="mb-3 col-md-6">
            <label for="equipmentNeeded" class="form-label">Equipment Needed:</label>
            <select multiple="multiple" name="program_equi_neede[]" class="form-control equipmentNeeded">
              <option value="Banana">Body</option>
              <option value="Apple">Legs</option>
              <option value="Banana">Back</option>
              <option value="Apple">Shoulder</option>
            </select>
          </div>
          <div class="mb-3 col-md-6">
            <label for="trainingType" class="form-label">Training Type:</label>
            <select multiple="multiple" name="program_training_type[]" class="form-control trainingType">
              <option value="Banana">Body</option>
              <option value="Apple">Legs</option>
              <option value="Banana">Back</option>
              <option value="Apple">Shoulder</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label for="file" class="form-label">Coach Name</label>
            <select class="form-select" name="coach_id[]" aria-label="Default select example">
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
            <input type="time" id="timeInput" name="program_duration[]" class="form-control" />
          </div>
          <div class="col-md-6 mb-3">
            <label for="file" class="form-label">Level</label>
            <select class="form-select" name="program_level[]" aria-label="Default select example">
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
          <!-- Initial accordion item -->
          <div class="accordion-item" id="workout1">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                Workout 1
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
              data-bs-parent="#accordionExample">
              <div class="accordion-body">

                <div class="row mb-3 bg-light py-3 rounded-3">

                  <div class="mb-3 col-md-6">
                    <label for="workout" class="form-label">Workout Name</label>
                    <input type="text" class="form-control" name="workout_name[]" id="workout" aria-describedby="emailHelp" />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="file" class="form-label">Introdutory Video</label>
                    <input type="file" class="form-control" id="file" name="workout_intro_video"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="file" class="form-label">Workout Text Bio</label>
                    <textarea name="workout_text_bio" id="" class="form-control"></textarea>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="trainingType" class="form-label">Training Type:</label>
                    <select multiple="multiple" name="workout_training_type[]" class="form-control trainingType">
                      <option value="Banana">Body</option>
                      <option value="Apple">Legs</option>
                      <option value="Banana">Back</option>
                      <option value="Apple">Shoulder</option>
                    </select>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="equipmentNeeded" class="form-label">Equipment Needed:</label>
                    <select multiple="multiple" name="workout_equi_needed[]" class="form-control equipmentNeeded">
                      <option value="Banana">Body</option>
                      <option value="Apple">Legs</option>
                      <option value="Banana">Back</option>
                      <option value="Apple">Shoulder</option>
                    </select>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="timeInput" class="form-label">Estimated Duration (hours)</label>
                    <input type="time" id="timeInput" name="workout_estimated_duration[]" class="form-control" />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="restDays" class="form-label">Rest (Days)</label>
                    <input type="tel" class="form-control" id="restDays" name="workout_rest_days[]" placeholder="1"
                      oninput="validateNumericInput(this)" />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="exercises" class="form-label">Number of Exercises</label>
                    <input type="number" class="form-control" name="workout_number_of_exercises[]" id="exercises" aria-describedby="emailHelp" />
                  </div>
                </div>
                <div class="">
                  <div class="">
                    <button type="button" class="add-set btn btn-primary mb-3">Add Set</button>
                    <button type="button" class="remove-set btn btn-primary mb-3">Remove Set</button>
                  </div>
                  <div class="row set-section mb-3 bg-light py-3 rounded-3">
                    <h2 id="set-heading">Set 1</h2>
                    <div class="col-md-6 mb-3">
                      <label for="setType" class="form-label">Set Type</label>
                      <select class="form-select" name="set_type[]" id="setType" aria-label="Default select example">
                        <option selected>Select Type</option>
                        <option value="set">Set</option>
                        <option value="super-set">Super Set</option>
                      </select>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="setType" class="form-label">Exercise</label>
                      <div class="row set-type-set">
                        <div class="col-md-4">
                          <input class="form-check-input" type="radio" name="set_exercises[]" value="1" id="flexRadioDefault1">
                          <label class="form-check-label" for="flexRadioDefault1">
                            Excersie 1
                          </label>
                        </div>
                        <div class=" col-md-4">
                          <input class="form-check-input" type="radio" name="set_exercises[]" value="2" id="flexRadioDefault2">
                          <label class="form-check-label" for="flexRadioDefault2">
                            Excersie 2
                          </label>
                        </div>
                        <div class=" col-md-4">
                          <input class="form-check-input" type="radio" name="set_exercises[]" value="3" id="flexRadioDefault3">
                          <label class="form-check-label" for="flexRadioDefault3">
                            Excersie 3
                          </label>
                        </div>
                        <div class="col-md-4">
                          <input class="form-check-input" type="radio" name="set_exercises[]" value="4" id="flexRadioDefault4">
                          <label class="form-check-label" for="flexRadioDefault4">
                            Excersie 4
                          </label>
                        </div>
                        <div class=" col-md-4">
                          <input class="form-check-input" type="radio" name="set_exercises[]" value="5" id="flexRadioDefault5">
                          <label class="form-check-label" for="flexRadioDefault5">
                            Excersie 5
                          </label>
                        </div>
                        <div class=" col-md-4">
                          <input class="form-check-input" type="radio" name="set_exercises[]" value="6" id="flexRadioDefault6">
                          <label class="form-check-label" for="flexRadioDefault6">
                            Excersie 6
                          </label>
                        </div>
                      </div>
                      <div class="row set-type-super-set">
                        <div class="col-md-4">
                          <input class="form-check-input" type="checkbox" name="" value="1" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckDefault">
                            Checkbox 1
                          </label>
                        </div>
                        <div class=" col-md-4">
                          <input class="form-check-input" type="checkbox" name="" value="1" id="flexCheckDefault2">
                          <label class="form-check-label" for="flexCheckDefault2">
                            Checkbox 2
                          </label>
                        </div>
                        <div class=" col-md-4">
                          <input class="form-check-input" type="checkbox" name="" value="1" id="flexCheckDefault3">
                          <label class="form-check-label" for="flexCheckDefault3">
                            Checkbox 3
                          </label>
                        </div>
                        <div class="col-md-4">
                          <input class="form-check-input" type="checkbox" name="" value="1" id="flexCheckDefault4">
                          <label class="form-check-label" for="flexCheckDefault4">
                            Checkbox 4
                          </label>
                        </div>
                        <div class=" col-md-4">
                          <input class="form-check-input" type="checkbox" name="" value="1" id="flexCheckDefault5">
                          <label class="form-check-label" for="flexCheckDefault5">
                            Checkbox 5
                          </label>
                        </div>
                        <div class=" col-md-4">
                          <input class="form-check-input" type="checkbox" name="" value="" id="flexCheckDefault6">
                          <label class="form-check-label" for="flexCheckDefault6">
                            Checkbox 6
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="set-time-number" class="form-label">Number of Time Set</label>
                      <input type="number" class="form-control" name="set_number_of_time_set[]" id="set-time-number" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="intra-set-rest" class="form-label">Intra-Set Rest</label>
                      <input type="number" name="set_intra_set_rest[]" class="form-control" id="intra-set-rest" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="inter-set-rest" class="form-label">Inter-Set Rest</label>
                      <input type="number" class="form-control" name="set_inter_set_rest[]" id="inter-set-rest" />
                    </div>
                    <div class="mb-3 col-md-6">
                      <label for="Duration-set" class="form-label">Duration of Set</label>
                      <input type="time" id="Duration-set" name="set_duration_set[]" class="form-control" />
                    </div>
                  </div>
                  <div class="">
                    <button type="button" class="add-exercise btn btn-primary mb-3">Add Exercise</button>
                    <button type="button" class="remove-exercise btn btn-primary mb-3">Remove Exercise</button>
                  </div>
                  <div class="row exercise-section mb-3 bg-light p-3 rounded-3">
                    <h2 id="exercise-heading">Exercise 1</h2>
                    <div class="col-md-6 mb-3">
                      <label for="set-time-number" class="form-label">Text Bio</label>
                      <div class="form-floating">
                        <textarea class="form-control" name="exercise_text_bio[]" placeholder="Leave a comment here"
                          id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Comments</label>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="repeat-num" class="form-label">Number of Repeatation</label>
                      <input type="number" class="form-control" name="exercise_number_of_repeat[]" id="repeat-num" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="formFile" class="form-label">Default file input example</label>
                      <input class="form-control" type="file" name="exercise_input_example" id="formFile">
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
      </form>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>





  <script>
    let workoutCount = 1;

    function addWorkout() {
      workoutCount++;

      // Clone the initial workout item and update its ID
      const clone = document.getElementById('workout1').cloneNode(true);
      clone.id = `workout${workoutCount}`;

      // Reset input values in the cloned workout
      const inputs = clone.querySelectorAll('input, select');
      inputs.forEach(input => input.value = '');

      // Update the accordion button and collapse content
      const accordionButton = clone.querySelector('.accordion-button');
      accordionButton.textContent = `Workout ${workoutCount}`;
      accordionButton.setAttribute('data-bs-target', `#collapse${workoutCount}`);
      accordionButton.setAttribute('aria-controls', `collapse${workoutCount}`);

      // Update the collapse div
      const collapseDiv = clone.querySelector('.accordion-collapse');
      collapseDiv.id = `collapse${workoutCount}`;
      collapseDiv.setAttribute('aria-labelledby', `heading${workoutCount}`);

      // Update heading numbers for set sections within the specific workout
      const setSections = clone.querySelectorAll('.set-section');
      setSections.forEach((setSection, index) => {
        const setHeading = setSection.querySelector('#set-heading');
        setHeading.textContent = `Set ${index + 1}`;
      });

      // Update heading numbers for exercise sections within the specific workout
      const exerciseSections = clone.querySelectorAll('.exercise-section');
      exerciseSections.forEach((exerciseSection, index) => {
        const exerciseHeading = exerciseSection.querySelector('#exercise-heading');
        exerciseHeading.textContent = `Exercise ${index + 1}`;
      });

      // Append the cloned workout to the accordion
      document.getElementById('accordionExample').appendChild(clone);
    }

    function removeWorkout() {
      // Check if there's more than one workout to remove
      if (workoutCount > 1) {
        const lastWorkout = document.getElementById(`workout${workoutCount}`);
        lastWorkout.remove();
        workoutCount--;
      }
    }


    $(document).ready(function () {
      $(".trainingType").select2({
        placeholder: "Search Training Type",
        tags: true,
        tokenSeparators: [",", " "],
        allowClear: true,
      });

      $(".trainingType").on("change", function () {
        updateSelectedtraining();
      });

      function updateSelectedtraining() {
        var selectedtraining = $(".trainingType").val();
        var selectedtrainingContainer = $("#selectedtraining");
        selectedtrainingContainer.empty();

        if (selectedtraining) {
          selectedtraining.forEach(function (training) {
            var selectedtrainingDiv = $(
              '<div class="selected-training"></div>'
            ).text(training);
            selectedtrainingContainer.append(selectedtrainingDiv);
          });
        }
      }
    });

    $(document).ready(function () {
      $(".equipmentNeeded").select2({
        placeholder: "Search Needy Equipment",
        tags: true,
        tokenSeparators: [",", " "],
        allowClear: true,
      });

      $(".equipmentNeeded").on("change", function () {
        updateSelectedtraining();
      });

      function updateSelectedtraining() {
        var selectedtraining = $(".equipmentNeeded").val();
        var selectedtrainingContainer = $("#selectedtraining");
        selectedtrainingContainer.empty();

        if (selectedtraining) {
          selectedtraining.forEach(function (equipment) {
            var selectedequipmentDiv = $(
              '<div class="selected-equipment"></div>'
            ).text(equipment);
            selectedtrainingContainer.append(selectedequipmentDiv);
          });
        }
      }
    });

    function validateNumericInput(input) {
      input.value = input.value.replace(/\D/g, ""); // Remove non-numeric characters
    }

    function validatePhoneNumber() {
      var phoneNumberInput = document.getElementById("restDays").value;

      // Check if the resulting value is a numeric value
      if (!isNaN(phoneNumberInput) && phoneNumberInput !== "") {
        alert("Phone number is valid!"); // You can replace this with your desired action
      } else {
        alert("Invalid phone number. Please enter numeric characters only.");
      }
    }
    function usdPrice() {
      var usdPrice = document.getElementById("usdPrice").value;

      // Check if the resulting value is a numeric value
      if (!isNaN(usdPrice) && usdPrice !== "") {
        alert("Phone number is valid!"); // You can replace this with your desired action
      } else {
        alert("Invalid phone number. Please enter numeric characters only.");
      }
    }

    $(document).ready(function () {
      // Hide both set-type-set and set-type-super-set initially
      $('.set-type-set, .set-type-super-set').hide();

      // Handle change event on the Set Type select
      $('#setType').change(function () {
        // Hide both set-type-set and set-type-super-set
        $('.set-type-set, .set-type-super-set').hide();

        // Show the selected set type section
        var selectedType = $(this).val();
        if (selectedType === 'set') {
          $('.set-type-set').show();
        } else if (selectedType === 'super-set') {
          $('.set-type-super-set').show();
        }
      });
    });


    $(document).ready(function () {
      // Add Set button click event
      $(document).on("click", ".add-set", function () {
        // Get the closest workout section to the clicked button
        var workoutSection = $(this).closest('.accordion-item');

        // Clone the last set section within the specific workout
        var clonedSet = workoutSection.find(".set-section:last").clone();

        // Clear values in the cloned set
        clonedSet.find("input, select").val('');

        // Update the heading number based on the total number of set sections within the specific workout
        var totalSetSections = workoutSection.find(".set-section").length + 1;
        clonedSet.find("#set-heading").text("Set " + totalSetSections);

        // Append the cloned set after the last set section within the specific workout
        workoutSection.find(".set-section:last").after(clonedSet);
      });

      // Remove Set button click event
      $(document).on("click", ".remove-set", function () {
        // Get the closest workout section to the clicked button
        var workoutSection = $(this).closest('.accordion-item');

        var totalSetSections = workoutSection.find(".set-section").length;

        // Make sure there is at least one set section to remove
        if (totalSetSections > 1) {
          // Remove the last set section within the specific workout
          workoutSection.find(".set-section:last").remove();

          // Update the heading numbers of the remaining set sections within the specific workout
          workoutSection.find(".set-section").each(function (index) {
            $(this).find("#set-heading").text("Set " + (index + 1));
          });
        }
      });

      // Add Exercise button click event
      $(document).on("click", ".add-exercise", function () {
        // Get the closest workout section to the clicked button
        var workoutSection = $(this).closest('.accordion-item');

        // Clone the last exercise section within the specific workout
        var clonedExercise = workoutSection.find(".exercise-section:last").clone();

        // Clear values in the cloned exercise
        clonedExercise.find("input, select").val('');

        // Update the heading number based on the total number of exercise sections within the specific workout
        var totalExerciseSections = workoutSection.find(".exercise-section").length + 1;
        clonedExercise.find("#exercise-heading").text("Exercise " + totalExerciseSections);

        // Append the cloned exercise after the last exercise section within the specific workout
        workoutSection.find(".exercise-section:last").after(clonedExercise);
      });

      // Remove Exercise button click event
      $(document).on("click", ".remove-exercise", function () {
        // Get the closest workout section to the clicked button
        var workoutSection = $(this).closest('.accordion-item');

        var totalExerciseSections = workoutSection.find(".exercise-section").length;

        // Make sure there is at least one exercise section to remove
        if (totalExerciseSections > 1) {
          // Remove the last exercise section within the specific workout
          workoutSection.find(".exercise-section:last").remove();

          // Update the heading numbers of the remaining exercise sections within the specific workout
          workoutSection.find(".exercise-section").each(function (index) {
            $(this).find("#exercise-heading").text("Exercise " + (index + 1));
          });
        }
      });
    });


  </script>
@endsection
