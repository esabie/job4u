const LOADER_ID = 'global-loader';
const MESSAGE_ID = 'global-loader-message';
const SPINNER_TEMPLATE_ID = 'button-spinner-template';

function getLoader() {
    return document.getElementById(LOADER_ID);
}

function getMessageEl() {
    return document.getElementById(MESSAGE_ID);
}

function getButtonSpinner() {
    const template = document.getElementById(SPINNER_TEMPLATE_ID);

    return template ? template.content.firstElementChild.cloneNode(true) : null;
}

export function showLoader(message = 'Loading...') {
    const loader = getLoader();

    if (!loader) {
        return;
    }

    const messageEl = getMessageEl();

    if (messageEl) {
        messageEl.textContent = message;
    }

    loader.style.display = 'flex';
    loader.setAttribute('aria-hidden', 'false');
    loader.setAttribute('aria-busy', 'true');
    loader.classList.remove('opacity-0', 'pointer-events-none');
}

export function hideLoader() {
    const loader = getLoader();

    if (!loader) {
        return;
    }

    loader.style.display = 'none';
    loader.setAttribute('aria-hidden', 'true');
    loader.setAttribute('aria-busy', 'false');
    loader.classList.add('opacity-0', 'pointer-events-none');
}

function setButtonLoading(button) {
    if (!button || button.dataset.loading === 'true') {
        return;
    }

    button.dataset.loading = 'true';
    button.dataset.originalHtml = button.innerHTML;
    button.disabled = true;
    button.classList.add('cursor-wait', 'opacity-80');

    const spinner = getButtonSpinner();
    const label = button.dataset.loadingText || button.textContent.trim();

    button.innerHTML = '';

    if (spinner) {
        button.appendChild(spinner);
    }

    const text = document.createElement('span');

    text.textContent = label;
    button.appendChild(text);
}

function shouldSkipForm(form) {
    return form.dataset.noLoader !== undefined
        || form.getAttribute('target') === '_blank';
}

function shouldSkipLink(link, event) {
    if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
        return true;
    }

    if (link.target === '_blank' || link.hasAttribute('download') || link.dataset.noLoader !== undefined) {
        return true;
    }

    const href = link.getAttribute('href');

    if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) {
        return true;
    }

    try {
        const url = new URL(link.href, window.location.origin);

        return url.origin !== window.location.origin;
    } catch {
        return true;
    }
}

function loaderMessageForForm(form) {
    return form.dataset.loaderMessage || 'Saving...';
}

function loaderMessageForLink(link) {
    return link.dataset.loaderMessage || 'Loading...';
}

function initLoadingStates() {
    hideLoader();

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (event.defaultPrevented || shouldSkipForm(form)) {
                return;
            }

            const submitter = event.submitter || form.querySelector('[type="submit"]');

            showLoader(loaderMessageForForm(form));
            setButtonLoading(submitter);
        });
    });

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a');

        if (shouldSkipLink(link, event)) {
            return;
        }

        showLoader(loaderMessageForLink(link));
    });

    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            hideLoader();
        }
    });
}

window.showLoader = showLoader;
window.hideLoader = hideLoader;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLoadingStates);
} else {
    initLoadingStates();
}
