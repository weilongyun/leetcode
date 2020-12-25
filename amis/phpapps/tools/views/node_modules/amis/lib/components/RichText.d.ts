/**
 * @file RichText
 * @description
 * @author fex
 */
import React from 'react';
import 'froala-editor/css/froala_style.min.css';
import 'froala-editor/css/froala_editor.pkgd.min.css';
export default class FroalaEditor extends React.Component<any, any> {
    listeningEvents: Array<any>;
    $element: any;
    $editor: any;
    config: any;
    editorInitialized: boolean;
    oldModel: any;
    constructor(props: any);
    componentDidUpdate(): void;
    textareaRef(ref: any): void;
    createEditor(ref: any): void;
    setContent(firstTime?: boolean): void;
    setNormalTagContent(firstTime: boolean): void;
    getEditor(): any;
    updateModel(): void;
    initListeners(): void;
    registerEvent(element: any, eventName: any, callback: any): void;
    registerEvents(): void;
    destroyEditor(): void;
    render(): JSX.Element;
}
