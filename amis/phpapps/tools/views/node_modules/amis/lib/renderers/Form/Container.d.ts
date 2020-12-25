/// <reference types="react" />
import Container, { ContainerSchema } from '../Container';
import { FormBaseControl, FormControlProps, FormControlSchema } from './Item';
import { IIRendererStore } from '../../store/iRenderer';
import { SchemaCollection } from '../../Schema';
/**
 * 容器空间
 * 文档：https://baidu.gitee.io/amis/docs/components/form/contaier
 */
export interface ContainerControlSchema extends FormBaseControl, Omit<ContainerSchema, 'body'> {
    type: 'container';
    body?: SchemaCollection;
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
export interface ContainerProps extends FormControlProps {
    store: IIRendererStore;
}
export declare class ContainerControlRenderer extends Container<ContainerProps> {
    static propsList: Array<string>;
    renderBody(): JSX.Element | null;
}
