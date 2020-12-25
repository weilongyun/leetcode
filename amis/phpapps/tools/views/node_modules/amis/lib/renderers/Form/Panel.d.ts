/// <reference types="react" />
import Panel, { PanelSchema } from '../Panel';
import { FormBaseControl, FormControlSchema } from './Item';
/**
 * 容器空间
 * 文档：https://baidu.gitee.io/amis/docs/components/form/contaier
 */
export interface PanelControlSchema extends FormBaseControl, PanelSchema {
    type: 'panel';
    /**
     * 表单项集合
     */
    controls?: Array<FormControlSchema>;
    /**
     * @deprecated 请用类型 tabs
     */
    tabs?: any;
    /**
     * @deprecated 请用类型 fieldSet
     */
    fieldSet?: any;
}
export declare class PanelRenderer extends Panel {
    static propsList: Array<string>;
    renderBody(): JSX.Element | null;
}
