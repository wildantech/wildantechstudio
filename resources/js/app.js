const revealTargets = document.querySelectorAll('[data-reveal]');
const midnightMoonTheme = document.querySelector('.theme-midnight-moon');

if (midnightMoonTheme) {
    document.addEventListener('visibilitychange', () => {
        midnightMoonTheme.classList.toggle('animations-paused', document.hidden);
    });
}

if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    revealTargets.forEach((target) => {
        target.classList.add('reveal-on-scroll');
        revealObserver.observe(target);
    });
} else {
    revealTargets.forEach((target) => target.classList.add('is-visible'));
}

const richEditorShells = document.querySelectorAll('[data-rich-editor-shell]');
const richEditorTags = new Set(['P', 'BR', 'STRONG', 'B', 'EM', 'I', 'U', 'H2', 'H3', 'BLOCKQUOTE', 'UL', 'OL', 'LI']);

const copySafeEditorNode = (node) => {
    if (node.nodeType === Node.TEXT_NODE) {
        return document.createTextNode(node.textContent);
    }

    if (node.nodeType !== Node.ELEMENT_NODE || ['SCRIPT', 'STYLE', 'IFRAME', 'OBJECT', 'SVG'].includes(node.tagName)) {
        return document.createDocumentFragment();
    }

    const safeChildren = document.createDocumentFragment();
    node.childNodes.forEach((child) => safeChildren.append(copySafeEditorNode(child)));

    if (!richEditorTags.has(node.tagName)) {
        return safeChildren;
    }

    const safeElement = document.createElement(node.tagName.toLowerCase());
    safeElement.append(safeChildren);
    return safeElement;
};

richEditorShells.forEach((shell) => {
    const editor = shell.querySelector('[data-rich-editor-content]');
    const source = shell.querySelector('.rich-editor-source');
    const toolbar = shell.querySelector('[data-rich-editor-toolbar]');
    const form = shell.closest('form');

    if (!editor || !source || !toolbar || !form) {
        return;
    }

    const initialValue = source.value.trim();
    if (initialValue && /<\/?(p|br|strong|b|em|i|u|h2|h3|blockquote|ul|ol|li)\b[^>]*>/i.test(initialValue)) {
        const template = document.createElement('template');
        template.innerHTML = initialValue;
        template.content.childNodes.forEach((node) => editor.append(copySafeEditorNode(node)));
    } else if (initialValue) {
        initialValue.split(/\n{2,}/).forEach((paragraph) => {
            const element = document.createElement('p');
            paragraph.split('\n').forEach((line, index) => {
                if (index > 0) {
                    element.append(document.createElement('br'));
                }
                element.append(document.createTextNode(line));
            });
            editor.append(element);
        });
    }

    shell.classList.add('is-enhanced');

    toolbar.querySelectorAll('[data-rich-command]').forEach((button) => {
        button.addEventListener('mousedown', (event) => event.preventDefault());
        button.addEventListener('click', () => {
            editor.focus();
            document.execCommand(button.dataset.richCommand, false);
            editor.dispatchEvent(new InputEvent('input', { bubbles: true }));
        });
    });

    const formatSelect = toolbar.querySelector('[data-rich-format]');
    formatSelect.addEventListener('change', () => {
        editor.focus();
        document.execCommand('formatBlock', false, '<' + formatSelect.value.toLowerCase() + '>');
        editor.dispatchEvent(new InputEvent('input', { bubbles: true }));
        formatSelect.value = 'P';
    });

    form.addEventListener('submit', () => {
        source.value = editor.innerHTML;
    });
});

const bookReaders = document.querySelectorAll('[data-book-reader]');

bookReaders.forEach((reader) => {
    const kind = reader.dataset.bookKind;
    const sourceUrl = reader.dataset.bookUrl;
    const stage = reader.querySelector('[data-book-stage]');
    const pageLabel = reader.querySelector('[data-book-page-label]');
    const swipeHint = reader.querySelector('.book-swipe-hint');
    const errorMessage = reader.querySelector('[data-book-error]');
    const cover = reader.querySelector('[data-book-cover]');
    const hasCover = reader.dataset.bookHasCover === 'true' && Boolean(cover);
    let pages = [];
    let rightPageIndex = 0;
    let isTurning = false;
    let isCoverOpen = !hasCover;

    const setError = (message) => {
        if (!errorMessage) {
            return;
        }

        errorMessage.hidden = false;
        errorMessage.textContent = message;
    };

    const splitIntoPages = (source, measureContent) => {
        const paragraphs = source.replace(/\r/g, '').split(/\n\s*\n/).map((paragraph) => paragraph.trim()).filter(Boolean);
        const result = [];
        let page = [];
        const escapeHtml = (value) => {
            const element = document.createElement('span');
            element.textContent = value;
            return element.innerHTML;
        };
        const fits = (candidate) => {
            measureContent.innerHTML = candidate.map((paragraph) => '<p>' + escapeHtml(paragraph) + '</p>').join('');
            return measureContent.scrollHeight <= measureContent.clientHeight + 1;
        };
        const savePage = () => {
            if (page.length) {
                result.push(page.join('\n\n'));
                page = [];
            }
        };

        paragraphs.forEach((paragraph) => {
            if (fits([...page, paragraph])) {
                page.push(paragraph);
                return;
            }

            savePage();
            if (fits([paragraph])) {
                page.push(paragraph);
                return;
            }

            const words = paragraph.split(/\s+/);
            let wordOffset = 0;
            while (wordOffset < words.length) {
                let bestFit = 0;
                let lower = 1;
                let upper = words.length - wordOffset;

                while (lower <= upper) {
                    const middle = Math.floor((lower + upper) / 2);
                    if (fits([words.slice(wordOffset, wordOffset + middle).join(' ')])) {
                        bestFit = middle;
                        lower = middle + 1;
                    } else {
                        upper = middle - 1;
                    }
                }

                const wordsToAdd = Math.max(1, bestFit);
                result.push(words.slice(wordOffset, wordOffset + wordsToAdd).join(' '));
                wordOffset += wordsToAdd;
            }
        });

        savePage();
        measureContent.replaceChildren();

        return result.length ? result : ['Naskah ini belum memiliki teks yang dapat ditampilkan.'];
    };

    const measureBookPage = () => {
        const measureReader = reader.cloneNode(true);
        measureReader.setAttribute('aria-hidden', 'true');
        measureReader.style.position = 'fixed';
        measureReader.style.top = '0';
        measureReader.style.left = '-10000px';
        measureReader.style.width = reader.clientWidth + 'px';
        measureReader.style.margin = '0';
        measureReader.style.visibility = 'hidden';
        measureReader.style.pointerEvents = 'none';

        const measureStage = measureReader.querySelector('[data-book-stage]');
        measureStage.classList.add('is-book-open');
        measureStage.style.transition = 'none';
        measureReader.querySelector('[data-book-cover]')?.remove();
        document.body.append(measureReader);

        return {
            content: measureReader.querySelector('[data-book-right-content]'),
            remove: () => measureReader.remove(),
        };
    };

    const readDocx = async (buffer) => {
        const bytes = new Uint8Array(buffer);
        const view = new DataView(buffer);
        let endRecord = -1;

        for (let offset = bytes.length - 22; offset >= Math.max(0, bytes.length - 65557); offset -= 1) {
            if (view.getUint32(offset, true) === 0x06054b50) {
                endRecord = offset;
                break;
            }
        }

        if (endRecord < 0) {
            throw new Error('Struktur berkas Word tidak terbaca.');
        }

        const entryCount = view.getUint16(endRecord + 10, true);
        const directoryOffset = view.getUint32(endRecord + 16, true);
        const decoder = new TextDecoder();
        let entryOffset = directoryOffset;

        for (let index = 0; index < entryCount; index += 1) {
            if (view.getUint32(entryOffset, true) !== 0x02014b50) {
                throw new Error('Daftar isi berkas Word tidak valid.');
            }

            const compression = view.getUint16(entryOffset + 10, true);
            const compressedSize = view.getUint32(entryOffset + 20, true);
            const filenameLength = view.getUint16(entryOffset + 28, true);
            const extraLength = view.getUint16(entryOffset + 30, true);
            const commentLength = view.getUint16(entryOffset + 32, true);
            const localHeaderOffset = view.getUint32(entryOffset + 42, true);
            const filenameStart = entryOffset + 46;
            const filename = decoder.decode(bytes.subarray(filenameStart, filenameStart + filenameLength));

            if (filename === 'word/document.xml') {
                const localFilenameLength = view.getUint16(localHeaderOffset + 26, true);
                const localExtraLength = view.getUint16(localHeaderOffset + 28, true);
                const contentStart = localHeaderOffset + 30 + localFilenameLength + localExtraLength;
                const compressedContent = bytes.subarray(contentStart, contentStart + compressedSize);
                let xmlText;

                if (compression === 0) {
                    xmlText = decoder.decode(compressedContent);
                } else if (compression === 8 && 'DecompressionStream' in window) {
                    const stream = new Blob([compressedContent])
                        .stream()
                        .pipeThrough(new DecompressionStream('deflate-raw'));
                    xmlText = await new Response(stream).text();
                } else {
                    throw new Error('Browser ini belum mendukung kompresi naskah Word tersebut.');
                }

                const xml = new DOMParser().parseFromString(xmlText, 'application/xml');
                if (xml.querySelector('parsererror')) {
                    throw new Error('Isi dokumen Word tidak dapat dibaca.');
                }

                const wordNamespace = 'http://schemas.openxmlformats.org/wordprocessingml/2006/main';
                return Array.from(xml.getElementsByTagNameNS(wordNamespace, 'p'))
                    .map((paragraph) => Array.from(paragraph.getElementsByTagNameNS(wordNamespace, 't'))
                        .map((textNode) => textNode.textContent)
                        .join(''))
                    .join('\n\n');
            }

            entryOffset += 46 + filenameLength + extraLength + commentLength;
        }

        throw new Error('Isi utama dokumen Word tidak ditemukan.');
    };

    const fillPage = (container, pageIndex, pageNumberElement) => {
        container.replaceChildren();

        if (pageIndex < 0 || pageIndex >= pages.length) {
            pageNumberElement.textContent = '';
            return;
        }

        pages[pageIndex].split(/\n\s*\n/).forEach((paragraph) => {
            const element = document.createElement('p');
            element.textContent = paragraph;
            container.append(element);
        });

        pageNumberElement.textContent = String(pageIndex + 1);
    };

    const renderSpread = () => {
        const isSinglePage = window.matchMedia('(max-width: 640px)').matches;
        const leftIndex = isSinglePage ? -1 : rightPageIndex - 1;
        const leftContent = reader.querySelector('[data-book-left-content]');
        const rightContent = reader.querySelector('[data-book-right-content]');
        const leftNumber = reader.querySelector('[data-book-left-number]');
        const rightNumber = reader.querySelector('[data-book-right-number]');

        fillPage(leftContent, leftIndex, leftNumber);
        fillPage(rightContent, rightPageIndex, rightNumber);

        if (pageLabel) {
            const firstVisible = isSinglePage ? rightPageIndex + 1 : Math.max(1, leftIndex + 1);
            const lastVisible = Math.min(pages.length, rightPageIndex + 1);
            pageLabel.textContent = hasCover && !isCoverOpen
                ? 'Sampul siap · geser ke kiri untuk membuka'
                : firstVisible === lastVisible
                    ? 'Halaman ' + firstVisible + ' dari ' + pages.length
                    : 'Halaman ' + firstVisible + '–' + lastVisible + ' dari ' + pages.length;
        }

        if (hasCover && swipeHint) {
            swipeHint.textContent = isCoverOpen
                ? 'Geser ke kiri untuk lanjut · ke kanan untuk kembali'
                : 'Geser sampul ke kiri untuk membaca';
        }

    };

    const openCover = () => {
        if (!hasCover || isCoverOpen) {
            return;
        }

        isCoverOpen = true;
        stage.classList.add('is-book-open');
        renderSpread();
    };

    const turnPage = (direction) => {
        if (isTurning) {
            return;
        }

        const isSinglePage = window.matchMedia('(max-width: 640px)').matches;
        const pageStep = isSinglePage ? 1 : 2;
        const nextPageIndex = rightPageIndex + direction * pageStep;
        const lastSpreadIndex = isSinglePage
            ? pages.length - 1
            : (pages.length % 2 === 0 ? pages.length - 1 : pages.length);
        if (nextPageIndex < 0 || nextPageIndex > lastSpreadIndex) {
            return;
        }

        isTurning = true;
        stage.classList.add(direction > 0 ? 'is-turning-forward' : 'is-turning-back');
        window.setTimeout(() => {
            rightPageIndex = Math.max(0, nextPageIndex);
            renderSpread();
        }, 220);
        window.setTimeout(() => {
            stage.classList.remove('is-turning-forward', 'is-turning-back');
            isTurning = false;
        }, 560);
    };

    if (kind === 'pdf') {
        const frame = reader.querySelector('[data-book-pdf]');
        let pdfPage = 1;
        let pdfPageCount = null;

        if (pageLabel) {
            pageLabel.textContent = 'PDF · Halaman 1';
        }

        function turnPdfPage(direction) {
            if (isTurning) {
                return;
            }

            if (direction < 0 && pdfPage === 1) {
                return;
            }

            if (direction > 0 && pdfPageCount !== null && pdfPage >= pdfPageCount) {
                return;
            }

            isTurning = true;
            stage.classList.add(direction > 0 ? 'is-turning-forward' : 'is-turning-back');
            window.setTimeout(() => {
                pdfPage += direction;
                frame.src = sourceUrl + '#toolbar=0&navpanes=0&page=' + pdfPage;
                pageLabel.textContent = 'PDF · Halaman ' + pdfPage + (pdfPageCount ? ' dari ' + pdfPageCount : '');
            }, 220);
            window.setTimeout(() => {
                stage.classList.remove('is-turning-forward', 'is-turning-back');
                isTurning = false;
            }, 560);
        }

        fetch(sourceUrl, { headers: { Range: 'bytes=0-262143' } })
            .then((response) => response.arrayBuffer().then((buffer) => ({ buffer, isPartial: response.status === 206 })))
            .then(({ buffer, isPartial }) => {
                const text = new TextDecoder('latin1').decode(buffer);
                const pageTreeCounts = Array.from(text.matchAll(/\/Type\s*\/Pages\b[\s\S]{0,2048}?\/Count\s+(\d+)/g))
                    .map((match) => Number(match[1]));
                if (pageTreeCounts.length > 0) {
                    pdfPageCount = Math.max(...pageTreeCounts);
                    pageLabel.textContent = 'PDF · Halaman 1 dari ' + pdfPageCount;
                } else if (!isPartial) {
                    const pageObjects = text.match(/\/Type\s*\/Page\b/g);
                    if (pageObjects && pageObjects.length > 0) {
                        pdfPageCount = pageObjects.length;
                        pageLabel.textContent = 'PDF · Halaman 1 dari ' + pdfPageCount;
                    }
                }
            })
            .catch(() => {});

        reader.turnPdfPage = turnPdfPage;
    } else if (kind === 'docx' || kind === 'txt') {
        fetch(sourceUrl)
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Naskah gagal dimuat. Coba unduh berkasnya.');
                }

                return kind === 'docx' ? response.arrayBuffer() : response.text();
            })
            .then((content) => kind === 'docx' ? readDocx(content) : content)
            .then((content) => {
                const measurement = measureBookPage();
                try {
                    pages = splitIntoPages(content, measurement.content);
                } finally {
                    measurement.remove();
                }
                rightPageIndex = !window.matchMedia('(max-width: 640px)').matches && pages.length > 1 ? 1 : 0;
                renderSpread();
            })
            .catch((error) => {
                setError(error.message + ' Kamu masih bisa membuka berkas aslinya di tab baru.');
                if (pageLabel) {
                    pageLabel.textContent = 'Pratinjau tidak tersedia';
                }
            });
    } else if (pageLabel) {
        pageLabel.textContent = 'Naskah Word';
    }

    if (cover) {
        cover.addEventListener('click', openCover);
    }

    let swipeStart = null;
    stage.addEventListener('pointerdown', (event) => {
        if (event.target.closest('a, button') && !event.target.closest('[data-book-cover]')) {
            return;
        }

        swipeStart = { x: event.clientX, y: event.clientY, pointerId: event.pointerId };
        stage.setPointerCapture(event.pointerId);
    });
    stage.addEventListener('pointerup', (event) => {
        if (!swipeStart) {
            return;
        }

        const deltaX = event.clientX - swipeStart.x;
        const deltaY = event.clientY - swipeStart.y;
        swipeStart = null;

        if (Math.abs(deltaX) < 48 || Math.abs(deltaX) < Math.abs(deltaY) * 1.2) {
            return;
        }

        const direction = deltaX < 0 ? 1 : -1;
        if (hasCover && !isCoverOpen) {
            if (direction > 0) {
                openCover();
            }
            return;
        }

        if (hasCover && isCoverOpen && direction < 0 && rightPageIndex <= (window.matchMedia('(max-width: 640px)').matches ? 0 : 1)) {
            isCoverOpen = false;
            stage.classList.remove('is-book-open');
            renderSpread();
            return;
        }

        if (kind === 'pdf') {
            reader.turnPdfPage(direction);
        } else {
            turnPage(direction);
        }
    });
    stage.addEventListener('pointercancel', () => {
        swipeStart = null;
    });
});

document.querySelectorAll('[data-poem-volume]').forEach((volume) => {
    const stack = volume.querySelector('[data-poem-stack]');
    const cover = volume.querySelector('[data-poem-cover]');
    const pageContent = volume.querySelector('[data-poem-page-content]');
    const pageNumber = volume.querySelector('[data-poem-page-number]');
    const pageLabel = volume.querySelector('[data-poem-page-label]');
    const swipeHint = volume.querySelector('[data-poem-swipe-hint]');
    const source = volume.querySelector('[data-poem-source]');
    const pages = [];
    let currentPage = -1;
    let swipeStart = null;

    const escapeHtml = (value) => {
        const element = document.createElement('span');
        element.textContent = value;
        return element.innerHTML;
    };

    const blocks = Array.from(source.children).map((element) => ({
        html: element.outerHTML,
        text: element.textContent.trim(),
    })).filter((block) => block.text);

    if (blocks.length === 0 && source.textContent.trim()) {
        source.textContent.trim().split(/\n\s*\n/).forEach((text) => {
            blocks.push({ html: '<p>' + escapeHtml(text.trim()) + '</p>', text: text.trim() });
        });
    }

    let currentBlocks = [];
    const fits = (candidate) => {
        pageContent.innerHTML = candidate.join('');
        return pageContent.scrollHeight <= pageContent.clientHeight + 1;
    };
    const savePage = () => {
        if (currentBlocks.length) {
            pages.push(currentBlocks.join(''));
            currentBlocks = [];
        }
    };

    blocks.forEach((block) => {
        if (fits([...currentBlocks, block.html])) {
            currentBlocks.push(block.html);
            return;
        }

        savePage();
        if (fits([block.html])) {
            currentBlocks.push(block.html);
            return;
        }

        const words = block.text.split(/\s+/);
        let wordOffset = 0;
        while (wordOffset < words.length) {
            let bestFit = 0;
            let lower = 1;
            let upper = words.length - wordOffset;

            while (lower <= upper) {
                const middle = Math.floor((lower + upper) / 2);
                const text = words.slice(wordOffset, wordOffset + middle).join(' ');
                if (fits(['<p>' + escapeHtml(text) + '</p>'])) {
                    bestFit = middle;
                    lower = middle + 1;
                } else {
                    upper = middle - 1;
                }
            }

            const wordsToAdd = Math.max(1, bestFit);
            currentBlocks.push('<p>' + escapeHtml(words.slice(wordOffset, wordOffset + wordsToAdd).join(' ')) + '</p>');
            wordOffset += wordsToAdd;
            if (wordOffset < words.length) {
                savePage();
            }
        }
    });
    savePage();

    if (pages.length === 0) {
        pages.push('<p>Puisi ini belum memiliki isi.</p>');
    }
    pageContent.innerHTML = pages[0];

    const showPage = (index) => {
        currentPage = index;
        stack.classList.toggle('is-open', currentPage >= 0);

        if (currentPage >= 0) {
            pageContent.innerHTML = pages[currentPage];
            pageNumber.textContent = String(currentPage + 1);
            pageLabel.textContent = 'Halaman ' + (currentPage + 1) + ' dari ' + pages.length;
            swipeHint.textContent = currentPage === 0
                ? 'Geser ke kiri untuk lanjut · ke kanan untuk sampul'
                : 'Geser ke kiri untuk lanjut · ke kanan untuk kembali';
        } else {
            pageLabel.textContent = 'Geser sampul ke kiri untuk membuka';
            swipeHint.textContent = 'Geser sampul ke kiri untuk membaca';
        }
    };

    const turnPage = (direction) => {
        if (currentPage < 0) {
            if (direction > 0) {
                showPage(0);
            }
            return;
        }

        const nextPage = currentPage + direction;
        if (nextPage < 0) {
            showPage(-1);
            return;
        }

        if (nextPage < pages.length) {
            showPage(nextPage);
        }
    };

    cover.addEventListener('click', () => {
        if (currentPage < 0) {
            showPage(0);
        }
    });

    stack.addEventListener('pointerdown', (event) => {
        swipeStart = { x: event.clientX, y: event.clientY };
        stack.setPointerCapture(event.pointerId);
    });
    stack.addEventListener('pointerup', (event) => {
        if (!swipeStart) {
            return;
        }

        const deltaX = event.clientX - swipeStart.x;
        const deltaY = event.clientY - swipeStart.y;
        swipeStart = null;

        if (Math.abs(deltaX) < 44 || Math.abs(deltaX) < Math.abs(deltaY) * 1.2) {
            return;
        }

        turnPage(deltaX < 0 ? 1 : -1);
    });
    stack.addEventListener('pointercancel', () => {
        swipeStart = null;
    });

    showPage(-1);
});
