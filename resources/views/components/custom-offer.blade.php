 {{-- Custom Offers Creation Models Start ============ --}}

 <!-- Modal -->
 <div class="modal" id="myModal">
     <div class="modal-dialog">
         <div class="modal-content date-modal">

             <div class="modal-body p-0">
                 <div class="head w-100">
                     <h1 class="text-center">What
                         service are you interested in?
                     </h1>
                 </div>
                 <div class="model-heading">
                     <p class="about">Curious about our
                         offerings? Let us know your
                         interests, and we'll tailor our
                         services to meet your specific
                         needs.</p>
                     <div class="d-flex option-btn">
                         <div class="d-flex radio-toolbar">
                             <div class="row">
                                 <div class="col-md-6">
                                     <input type="radio" id="offerTypeClass" name="offer_type" value="Class" checked
                                         data-bs-toggle="modal" data-bs-target="#secondModal" data-bs-dismiss="modal">
                                     <label for="offerTypeClass">
                                         <p class="label mb-0">
                                             Class
                                             Booking</p>
                                         <p class="name-label mb-0">
                                             Effortless
                                             class
                                             booking for
                                             a seamless
                                             learning
                                             experience.
                                         </p>
                                     </label>

                                 </div>
                                 <div class="col-md-6">
                                     <input type="radio" id="offerTypeFreelance" name="offer_type" value="Freelance"
                                         data-bs-toggle="modal" data-bs-target="#thirdModal" data-bs-dismiss="modal">
                                     <label for="offerTypeFreelance">
                                         <p class="label mb-0">
                                             Freelance
                                             Booking</p>
                                         <p class="name-label mb-0">
                                             Simplify
                                             your
                                             freelancing
                                             journey with
                                             quick and
                                             hassle-free
                                             bookings.
                                         </p>

                                     </label>
                                 </div>
                             </div>


                         </div>
                     </div>
                     <div class="model-footer">
                         <button class="back-btn" data-bs-dismiss="modal" aria-label="Close">Back</button>
                         <button class="next-btn">Next</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal -->
 <div class="modal custom-modal" id="secondModal">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <i class="fa-solid fa-arrow-left" data-bs-target="#myModal" data-bs-toggle="modal"
                     data-bs-dismiss="modal" style="cursor: pointer;"></i>
                 <h5 class="modal-title">Select Any
                     Class Service</h5>
             </div>
             <div class="modal-body bg-white service-list">
                 <!-- Services will be loaded dynamically via AJAX -->
                 <div class="text-center p-4">
                     <p class="text-muted">Loading
                         services...</p>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal -->
 <div class="modal custom-modal" id="thirdModal">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <i class="fa-solid fa-arrow-left" data-bs-target="#myModal" data-bs-toggle="modal"
                     data-bs-dismiss="modal" style="cursor: pointer;"></i>
                 <h5 class="modal-title">Select Any
                     Freelance Service</h5>
             </div>
             <div class="modal-body bg-white service-list">
                 <!-- Services will be loaded dynamically via AJAX -->
                 <div class="text-center p-4">
                     <p class="text-muted">Loading
                         services...</p>
                 </div>
             </div>
         </div>
     </div>
     <!-- Service Mode Selection Modal -->
     <div class="modal custom-modal" id="servicemode-modal">
         <div class="modal-dialog">
             <div class="modal-content date-modal">
                 <div class="modal-body p-0">
                     <div class="modal-header">
                         <h5 class="modal-title">Select
                             Service Mode</h5>
                     </div>
                     <div class="model-heading">
                         <p class="about">Choose how
                             the service will be
                             delivered.</p>
                         <div class="d-flex option-btn">
                             <div class="d-flex radio-toolbar">
                                 <div class="row">
                                     <div class="col-md-6">
                                         <input type="radio" id="serviceModeOnline" name="service_mode" value="Online"
                                             checked data-bs-toggle="modal" data-bs-target="#fourmodal"
                                             data-bs-dismiss="modal">
                                         <label for="serviceModeOnline">
                                             <p class="label mb-0">
                                                 Online
                                             </p>
                                             <p class="name-label mb-0">
                                                 Service
                                                 will be
                                                 delivered
                                                 remotely
                                                 via
                                                 video
                                                 call or
                                                 online
                                                 platform.
                                             </p>
                                         </label>
                                     </div>
                                     <div class="col-md-6">
                                         <input type="radio" id="serviceModeInPerson" name="service_mode"
                                             value="In-person" data-bs-toggle="modal" data-bs-target="#fourmodal"
                                             data-bs-dismiss="modal">
                                         <label for="serviceModeInPerson">
                                             <p class="label mb-0">
                                                 In-person
                                             </p>
                                             <p class="name-label mb-0">
                                                 Service
                                                 will be
                                                 delivered
                                                 in
                                                 person
                                                 at a
                                                 physical
                                                 location.
                                             </p>
                                         </label>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="model-footer">
                             <button class="back-btn" data-bs-target="#secondModal" data-bs-toggle="modal"
                                 data-bs-dismiss="modal">Back</button>
                             <button class="next-btn">Next</button>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- Payment Type Selection Modal -->
     <div class="modal custom-modal" id="fourmodal">
         <div class="modal-dialog">
             <div class="modal-content date-modal">

                 <div class="modal-body p-0">
                     <div class="modal-header">

                         <h5 class="modal-title">Choose
                             how you want to get paid
                         </h5>
                     </div>

                     <div class="model-heading">
                         <p class="about">Get paid in
                             full once the project is
                             completed, or break it into
                             smaller
                             chunks, called milestones,
                             to get paid as you go.</p>
                         <div class="d-flex option-btn">
                             <div class="d-flex radio-toolbar">
                                 <div class="row">
                                     <div class="col-md-6">
                                         <input type="radio" id="paymentTypeSingle" name="payment_type"
                                             value="Single" checked>
                                         <label for="paymentTypeSingle" data-bs-target="#sixModal"
                                             data-bs-toggle="modal" data-bs-dismiss="modal">
                                             <p class="label mb-0">
                                                 Single
                                                 Payment
                                             </p>
                                             <p class="name-label mb-0">
                                                 Get full
                                                 payment
                                                 after
                                                 completed
                                                 each
                                                 order at
                                                 once.
                                             </p>

                                         </label>
                                     </div>
                                     <div class="col-md-6">
                                         <input type="radio" id="paymentTypeMilestone" name="payment_type"
                                             value="Milestone">
                                         <label for="paymentTypeMilestone" data-bs-target="#fiveModal"
                                             data-bs-toggle="modal" data-bs-dismiss="modal">
                                             <p class="label mb-0">
                                                 Milestones
                                             </p>
                                             <p class="name-label mb-0">
                                                 Work in
                                                 gradual
                                                 steps
                                                 and get
                                                 each
                                                 completed
                                                 milestone.
                                             </p>

                                         </label>
                                     </div>
                                 </div>


                             </div>
                         </div>
                         <div class="model-footer">
                             <button class="back-btn" data-bs-target="#servicemode-modal" data-bs-toggle="modal"
                                 data-bs-dismiss="modal">Back</button>
                             <button class="next-btn">Next</button>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

     </div>
     <div class="modal" id="fiveModal">
         <div class="modal-dialog">
             <div class="modal-content date-modal">
                 <div class="modal-body p-0">
                     <div class="modal-header custom-modal">

                         <h5 class="modal-title">Create
                             a milestone offer</h5>
                     </div>

                     <div class="model-heading bg-white p-3 freelancing">

                         <p class="offer-title"><span class="selected-service-title">Loading...</span>
                         </p>
                         <textarea class="form-control offer-area" id="offer-description" name="offer"
                             placeholder="Describe your offer...."></textarea>
                         <p class="offer-title mt-3">Set
                             up your milestones or <a href="#" data-bs-target="#sixModal"
                                 data-bs-toggle="modal" data-bs-dismiss="modal">switch
                                 to single payment</a>
                         </p>
                         <p class="offer-title">Divide
                             your work into pre-defined
                             steps with goals (minimum
                             $10 for each milestone).</p>

                         <!-- Milestones Container - will be populated by JavaScript -->
                         <div id="milestones-container">
                             <!-- Milestones will be rendered dynamically by custom-offers.js -->
                         </div>

                         <button type="button" id="add-milestone-btn" class="btn btn-primary mt-3">
                             <i class="fa-solid fa-plus"></i>
                             Add Milestone
                         </button>

                         <!-- Total Amount Display -->
                         <div class="row mt-4">
                             <div class="col-md-12">
                                 <h4>Total Amount: <span class="total-amount-display text-primary">$0.00</span>
                                 </h4>
                             </div>
                         </div>

                         <div class="rado mt-3">
                             <div class="row">
                                 <div class="col-md-9">
                                     <div class="form-check form-1">
                                         <input class="form-check-input" type="checkbox" id="offer-expire-checkbox">
                                         <label class="form-check-label" for="offer-expire-checkbox">
                                             Offer Expire
                                         </label>
                                     </div>
                                     <div class="form-check">
                                         <input class="form-check-input" type="checkbox"
                                             id="request-requirements-checkbox">
                                         <label class="form-check-label" for="request-requirements-checkbox">
                                             Request for
                                             Requirements
                                         </label>
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="rectangle-desc desc-1">
                                         <select class="form-select" id="expire-days-select" disabled>
                                             <option value="1">
                                                 1 day
                                             </option>
                                             <option value="2">
                                                 2 days
                                             </option>
                                             <option value="3">
                                                 3 days
                                             </option>
                                             <option value="5" selected>
                                                 5 days
                                             </option>
                                             <option value="7">
                                                 7 days
                                             </option>
                                             <option value="14">
                                                 14 days
                                             </option>
                                         </select>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="model-footer mt-4">
                             <button class="bacck-btn" data-bs-target="#fourmodal" data-bs-toggle="modal"
                                 data-bs-dismiss="modal">Back</button>
                             <button class="neext-btn" id="submit-milestone-offer-btn">Send
                                 Offer</button>
                         </div>

                     </div>
                     <div class="model-footer">
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <!-- six modal -->
     <div class="modal" id="sixModal">
         <div class="modal-dialog">
             <div class="modal-content date-modal">
                 <div class="modal-body p-0">
                     <div class="modal-header custom-modal">

                         <h5 class="modal-title">Create
                             a single payment offer</h5>
                     </div>

                     <div class="model-heading bg-white p-3 freelancing">

                         <p class="offer-title"><span class="selected-service-title">Loading...</span>
                         </p>
                         <textarea class="form-control offer-area" id="offer-description" placeholder="Describe your offer...."></textarea>
                         <p class="offer-title mt-3">
                             Single payment or <a href="#" data-bs-target="#fiveModal" data-bs-toggle="modal"
                                 data-bs-dismiss="modal">switch
                                 to milestones</a></p>
                         <p class="offer-title">Set your
                             pricing and delivery terms
                             (minimum $10).</p>


                         <div class="row mt-3">
                             <div class="col-md-4 rectangle-desc">
                                 <div class="rectangle">
                                     <h3>Revisions</h3>
                                     <select class="form-select" id="single-payment-revisions">
                                         <option value="0">
                                             No revisions
                                         </option>
                                         <option value="1" selected>1
                                         </option>
                                         <option value="2">
                                             2</option>
                                         <option value="3">
                                             3</option>
                                         <option value="4">
                                             4</option>
                                         <option value="5">
                                             5</option>
                                     </select>
                                 </div>

                             </div>
                             <div class="col-md-4 rectangle-desc">
                                 <div class="rectangle">
                                     <h3>Delivery</h3>
                                     <select class="form-select" id="single-payment-delivery">
                                         <option value="1">
                                             1 day
                                         </option>
                                         <option value="2">
                                             2 days
                                         </option>
                                         <option value="3">
                                             3 days
                                         </option>
                                         <option value="5" selected>5
                                             days
                                         </option>
                                         <option value="7">
                                             1 week
                                         </option>
                                         <option value="14">
                                             2 weeks
                                         </option>
                                         <option value="30">
                                             1 month
                                         </option>
                                     </select>

                                 </div>

                             </div>
                             <div class="col-md-4 rectangle-desc">
                                 <div class="rectangle">
                                     <h3>Price</h3>
                                     <input type="number" class="form-control" id="single-payment-price"
                                         placeholder="Enter price" min="10" step="0.01" required>
                                 </div>

                             </div>
                         </div>

                         <!-- Total Amount Display -->
                         <div class="row mt-4">
                             <div class="col-md-12">
                                 <h4>Total Amount: <span class="total-amount-display text-primary">$0.00</span>
                                 </h4>
                             </div>
                         </div>

                         <div class="rado mt-3">
                             <div class="row">
                                 <div class="col-md-9">
                                     <div class="form-check form-1">
                                         <input class="form-check-input" type="checkbox" id="offer-expire-checkbox">
                                         <label class="form-check-label" for="offer-expire-checkbox">
                                             Offer Expire
                                         </label>
                                     </div>
                                     <div class="form-check">
                                         <input class="form-check-input" type="checkbox"
                                             id="request-requirements-checkbox">
                                         <label class="form-check-label" for="request-requirements-checkbox">
                                             Request for
                                             Requirements
                                         </label>
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="rectangle-desc desc-1">

                                         <select class="form-select" id="expire-days-select" disabled>
                                             <option value="1">
                                                 1 day
                                             </option>
                                             <option value="2">
                                                 2 days
                                             </option>
                                             <option value="3">
                                                 3 days
                                             </option>
                                             <option value="5" selected>
                                                 5 days
                                             </option>
                                             <option value="7">
                                                 7 days
                                             </option>
                                             <option value="14">
                                                 14 days
                                             </option>
                                         </select>

                                     </div>
                                 </div>
                             </div>


                         </div>
                         <div class="model-footer mt-4">
                             <button class="bacck-btn" data-bs-target="#fourmodal" data-bs-toggle="modal"
                                 data-bs-dismiss="modal">Back</button>
                             <button class="neext-btn" id="submit-single-offer-btn">Send
                                 Offer</button>
                         </div>

                     </div>

                     <div class="model-footer">
                     </div>
                 </div>
             </div>
         </div>
     </div>

     {{-- Custom Offers Creation Models END ============ --}}


 </div>
