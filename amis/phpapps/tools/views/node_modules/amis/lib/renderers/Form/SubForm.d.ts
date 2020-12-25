import React from 'react';
import { FormControlProps, FormBaseControl } from './Item';
import { SchemaClassName } from '../../Schema';
import { FormSchema } from '.';
/**
 * SubForm 子表单
 * 文档：https://baidu.gitee.io/amis/docs/components/form/subform
 */
export interface SubFormControlSchema extends FormBaseControl {
    /**
     * 指定为 SubForm 子表单
     */
    type: 'form';
    /**
     * 占位符
     */
    placeholder?: string;
    /**
     * 是否多选
     */
    multiple?: boolean;
    /**
     * 最少个数
     */
    minLength?: number;
    /**
     * 最多个数
     */
    maxLength?: number;
    /**
     * 当值中存在这个字段，则按钮名称将使用此字段的值来展示。
     */
    labelField?: string;
    /**
     * 按钮默认名称
     * @default 设置
     */
    btnLabel?: string;
    /**
     * 新增按钮 CSS 类名
     */
    addButtonClassName?: SchemaClassName;
    /**
     * 修改按钮 CSS 类名
     */
    editButtonClassName?: SchemaClassName;
    /**
     * 子表单详情
     */
    form?: Omit<FormSchema, 'type'>;
}
export interface SubFormProps extends FormControlProps {
    placeholder?: string;
    multiple?: boolean;
    minLength?: number;
    maxLength?: number;
    labelField?: string;
}
export interface SubFormState {
    openedIndex: number;
    optionIndex: number;
}
export default class SubFormControl extends React.PureComponent<SubFormProps, SubFormState> {
    static defaultProps: Partial<SubFormProps>;
    state: SubFormState;
    constructor(props: SubFormProps);
    addItem(): void;
    removeItem(key: number, e: React.UIEvent<any>): void;
    open(index?: number): void;
    close(): void;
    handleDialogConfirm(values: Array<object>): void;
    buildDialogSchema(): {
        type: string;
        body: {
            type: string;
        };
    };
    renderMultipe(): JSX.Element[];
    renderSingle(): JSX.Element;
    render(): JSX.Element;
}
export declare class SubFormControlRenderer extends SubFormControl {
}
