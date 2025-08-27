/**
 * Admin Speaker Selection JavaScript
 * Handles dynamic speaker selection and host speaker assignment in admin forms
 */

class AdminSpeakerSelection {
  constructor(options = {}) {
    this.speakersSelectId = options.speakersSelectId || "speakers";
    this.hostSpeakerSelectId = options.hostSpeakerSelectId || "host_speaker";
    this.hostSpeakerHelpId = options.hostSpeakerHelpId || "host-speaker-help";

    this.speakersSelect = null;
    this.hostSpeakerSelect = null;
    this.hostSpeakerHelp = null;

    this.isLoading = false;
    this.validationErrors = [];

    this.init();
  }

  init() {
    // Wait for DOM to be ready
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => this.setup());
    } else {
      this.setup();
    }
  }

  setup() {
    // Get DOM elements
    this.speakersSelect = document.getElementById(this.speakersSelectId);
    this.hostSpeakerSelect = document.getElementById(this.hostSpeakerSelectId);
    this.hostSpeakerHelp = document.getElementById(this.hostSpeakerHelpId);

    if (!this.speakersSelect || !this.hostSpeakerSelect) {
      console.warn("AdminSpeakerSelection: Required elements not found");
      return;
    }

    this.bindEvents();
    this.initializeState();
  }

  bindEvents() {
    // Speaker selection change event
    this.speakersSelect.addEventListener("change", (e) => {
      this.handleSpeakersChange(e);
    });

    // Host speaker selection change event
    this.hostSpeakerSelect.addEventListener("change", (e) => {
      this.handleHostSpeakerChange(e);
    });

    // Form submission validation
    const form = this.speakersSelect.closest("form");
    if (form) {
      form.addEventListener("submit", (e) => {
        this.handleFormSubmit(e);
      });
    }

    // Handle browser back/forward navigation
    window.addEventListener("pageshow", () => {
      this.initializeState();
    });
  }

  initializeState() {
    // Initialize the host speaker dropdown based on current selections
    this.updateHostSpeakerOptions();

    // Restore any existing selections (for edit forms or validation errors)
    this.restoreSelections();
  }

  handleSpeakersChange(event) {
    this.showLoadingState();

    // Small delay to show loading state
    setTimeout(() => {
      this.updateHostSpeakerOptions();
      this.validateSpeakerSelection();
      this.hideLoadingState();
    }, 100);
  }

  handleHostSpeakerChange(event) {
    this.validateHostSpeakerSelection();
  }

  handleFormSubmit(event) {
    this.clearValidationErrors();

    if (!this.validateForm()) {
      event.preventDefault();
      this.showValidationErrors();
      return false;
    }

    return true;
  }

  updateHostSpeakerOptions() {
    const selectedSpeakers = Array.from(this.speakersSelect.selectedOptions);
    const currentHostSpeaker = this.hostSpeakerSelect.value;

    // Clear existing options except the first one
    this.hostSpeakerSelect.innerHTML =
      '<option value="">Select host speaker</option>';

    if (selectedSpeakers.length === 0) {
      this.disableHostSpeakerSelect();
      return;
    }

    this.enableHostSpeakerSelect();

    // Add options for selected speakers
    selectedSpeakers.forEach((option) => {
      const hostOption = document.createElement("option");
      hostOption.value = option.value;
      hostOption.textContent = option.textContent;

      // Restore previous selection if it's still valid
      if (option.value === currentHostSpeaker) {
        hostOption.selected = true;
      }

      this.hostSpeakerSelect.appendChild(hostOption);
    });

    // If current host speaker is no longer in selected speakers, clear it
    if (
      currentHostSpeaker &&
      !selectedSpeakers.some((option) => option.value === currentHostSpeaker)
    ) {
      this.hostSpeakerSelect.value = "";
      this.showHostSpeakerClearedMessage();
    }
  }

  disableHostSpeakerSelect() {
    this.hostSpeakerSelect.disabled = true;
    this.hostSpeakerSelect.value = "";

    if (this.hostSpeakerHelp) {
      this.hostSpeakerHelp.textContent =
        "Select speakers first to choose a host speaker";
      this.hostSpeakerHelp.className = "form-text text-muted";
    }
  }

  enableHostSpeakerSelect() {
    this.hostSpeakerSelect.disabled = false;

    if (this.hostSpeakerHelp) {
      this.hostSpeakerHelp.textContent =
        "Choose one speaker to be the host speaker";
      this.hostSpeakerHelp.className = "form-text text-muted";
    }
  }

  showHostSpeakerClearedMessage() {
    if (this.hostSpeakerHelp) {
      this.hostSpeakerHelp.textContent =
        "Host speaker was cleared because they were removed from selected speakers";
      this.hostSpeakerHelp.className = "form-text text-warning";

      // Reset message after 3 seconds
      setTimeout(() => {
        if (this.hostSpeakerSelect.disabled) {
          this.disableHostSpeakerSelect();
        } else {
          this.enableHostSpeakerSelect();
        }
      }, 3000);
    }
  }

  showLoadingState() {
    if (this.isLoading) return;

    this.isLoading = true;
    this.hostSpeakerSelect.disabled = true;

    if (this.hostSpeakerHelp) {
      this.hostSpeakerHelp.innerHTML =
        '<i class="fas fa-spinner fa-spin"></i> Updating host speaker options...';
      this.hostSpeakerHelp.className = "form-text text-info";
    }
  }

  hideLoadingState() {
    this.isLoading = false;
  }

  validateSpeakerSelection() {
    const selectedSpeakers = Array.from(this.speakersSelect.selectedOptions);

    // Clear previous validation state
    this.speakersSelect.classList.remove("is-invalid");
    this.removeValidationMessage(this.speakersSelect);

    // No validation errors for empty selection (it's optional)
    return true;
  }

  validateHostSpeakerSelection() {
    const hostSpeakerId = this.hostSpeakerSelect.value;
    const selectedSpeakerIds = Array.from(
      this.speakersSelect.selectedOptions
    ).map((option) => option.value);

    // Clear previous validation state
    this.hostSpeakerSelect.classList.remove("is-invalid");
    this.removeValidationMessage(this.hostSpeakerSelect);

    // If host speaker is selected, it must be in the selected speakers
    if (hostSpeakerId && !selectedSpeakerIds.includes(hostSpeakerId)) {
      this.addValidationError(
        "host_speaker",
        "Host speaker must be selected from the assigned speakers"
      );
      this.hostSpeakerSelect.classList.add("is-invalid");
      this.showValidationMessage(
        this.hostSpeakerSelect,
        "Host speaker must be selected from the assigned speakers"
      );
      return false;
    }

    return true;
  }

  validateForm() {
    this.validationErrors = [];

    let isValid = true;

    // Validate speaker selection
    if (!this.validateSpeakerSelection()) {
      isValid = false;
    }

    // Validate host speaker selection
    if (!this.validateHostSpeakerSelection()) {
      isValid = false;
    }

    return isValid;
  }

  addValidationError(field, message) {
    this.validationErrors.push({ field, message });
  }

  showValidationErrors() {
    this.validationErrors.forEach((error) => {
      console.error(`Validation error for ${error.field}: ${error.message}`);
    });
  }

  clearValidationErrors() {
    this.validationErrors = [];

    // Clear visual validation states
    this.speakersSelect.classList.remove("is-invalid");
    this.hostSpeakerSelect.classList.remove("is-invalid");

    this.removeValidationMessage(this.speakersSelect);
    this.removeValidationMessage(this.hostSpeakerSelect);
  }

  showValidationMessage(element, message) {
    this.removeValidationMessage(element);

    const feedback = document.createElement("div");
    feedback.className = "invalid-feedback";
    feedback.textContent = message;
    feedback.setAttribute("data-speaker-validation", "true");

    element.parentNode.appendChild(feedback);
  }

  removeValidationMessage(element) {
    const existingFeedback = element.parentNode.querySelector(
      '[data-speaker-validation="true"]'
    );
    if (existingFeedback) {
      existingFeedback.remove();
    }
  }

  restoreSelections() {
    // This method can be overridden or extended for specific restoration logic
    // For example, restoring selections from server-side validation errors

    // Check for any data attributes that might contain restoration data
    const speakersData = this.speakersSelect.getAttribute("data-selected");
    const hostSpeakerData =
      this.hostSpeakerSelect.getAttribute("data-selected");

    if (speakersData) {
      try {
        const selectedIds = JSON.parse(speakersData);
        Array.from(this.speakersSelect.options).forEach((option) => {
          option.selected = selectedIds.includes(option.value);
        });
        this.updateHostSpeakerOptions();
      } catch (e) {
        console.warn("Failed to restore speaker selections:", e);
      }
    }

    if (hostSpeakerData) {
      this.hostSpeakerSelect.value = hostSpeakerData;
    }
  }

  // Public API methods
  getSelectedSpeakers() {
    return Array.from(this.speakersSelect.selectedOptions).map((option) => ({
      id: option.value,
      name: option.textContent,
    }));
  }

  getHostSpeaker() {
    const hostOption = this.hostSpeakerSelect.selectedOptions[0];
    return hostOption
      ? {
          id: hostOption.value,
          name: hostOption.textContent,
        }
      : null;
  }

  setSelectedSpeakers(speakerIds) {
    Array.from(this.speakersSelect.options).forEach((option) => {
      option.selected = speakerIds.includes(option.value);
    });
    this.updateHostSpeakerOptions();
  }

  setHostSpeaker(speakerId) {
    this.hostSpeakerSelect.value = speakerId;
  }

  // Utility method to refresh the component state
  refresh() {
    this.updateHostSpeakerOptions();
    this.validateForm();
  }
}

// Auto-initialize if elements are present
document.addEventListener("DOMContentLoaded", function () {
  const speakersSelect = document.getElementById("speakers");
  const hostSpeakerSelect = document.getElementById("host_speaker");

  if (speakersSelect && hostSpeakerSelect) {
    window.adminSpeakerSelection = new AdminSpeakerSelection();
  }
});

// Export for module usage
if (typeof module !== "undefined" && module.exports) {
  module.exports = AdminSpeakerSelection;
}
